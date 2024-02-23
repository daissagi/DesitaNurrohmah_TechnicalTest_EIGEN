<?php

namespace App\Models;

use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;


class Transaction extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'transaction_id';
    protected $fillable = ['book_code', 'member_code', 'borrowed_at', 'returned_at'];
    protected $dates = ['returned_at'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_code', 'member_code');
    }

    /**
     * @param array $attributes
     * @return Transaction
     */
    public function createTransaction(array $attributes){

        $transaction = $this->where('member_code', $attributes["member_code"])->first();
       
        $borrowedBooksCount = $transaction->whereNull('returned_at')->count();
        if ($transaction && $borrowedBooksCount > 2) {
            throw ValidationException::withMessages(['member_code' => 'Member has reached the borrowing limit and cannot borrow more books.']);       
        }    

        if ($transaction->isMemberPenalized()) {
            throw ValidationException::withMessages(['member_code' => 'Member is currently penalized and cannot make a new transaction.']);
        }

        if (!$transaction) {
            throw ValidationException::withMessages("Transaction not found for member code: {$attributes["member_code"]}");
        }
        
        if (!$transaction || !$transaction->isMemberPenalized() || $borrowedBooksCount <= 2) {
           
            $transaction = new self();
                $transaction->book_code = $attributes["book_code"];
                $transaction->member_code = $attributes["member_code"];
                $transaction->borrowed_at = $attributes["borrowed_at"];
                $transaction->returned_at = $attributes["returned_at"];
                $transaction->save();
    
                // Decrease the stock of the book
                $book = Book::where('book_code', $attributes["book_code"])->firstOrFail();
                $book->stock = max(0, $book->stock - 1);
                $book->save();
    
                return $transaction;  
        }
    }

    public function isMemberPenalized()
    {
        // Mengambil tanggal pengembalian buku terakhir
        $lastReturnedAt = $this->whereNotNull('returned_at')->latest('returned_at')->value('returned_at');

        // Debug: Tampilkan nilai $lastReturnedAt menggunakan dd()
        // dd($lastReturnedAt);

        // Pastikan bahwa $lastReturnedAt adalah objek Carbon
        $lastReturnedAt = \Carbon\Carbon::parse($lastReturnedAt);

        // Jika member belum pernah mengembalikan buku, return false
        if (!$lastReturnedAt) {
            return false;
        }

        // Menghitung selisih hari antara tanggal pengembalian buku terakhir dengan tanggal sekarang
        $today = now();
        $penaltyStartDate = $lastReturnedAt->addDays(3); 

        return $today->greaterThan($penaltyStartDate);
    }

    public function isReturnedAfterDueDate()
    {
        $returnedAt = $this->returned_at;

        if (!$returnedAt) {
            return false;
        }

        $dueDate = $this->borrowed_at->addDays(7);

        return $returnedAt->greaterThan($dueDate);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function BorrowedBooksInfo()
    {
        $members = $this::select('member_code')->distinct()->get();

        foreach ($members as $member) {
            $transactions = $this->where('member_code', $member->member_code)->get();
            
            $booksBorrowedCount = 0;
            
            foreach ($transactions as $transaction) {
                $booksBorrowedCount = $transaction->borrowedBooksCount();
            }

            $memberName = $transactions->first()->member->name;

            echo "Member {$member->member_code} ({$memberName}) has borrowed {$booksBorrowedCount} books.\n";
        }
    }

    public function borrowedBooksCount()
    {
        return $this->where('member_code', $this->member_code)->whereNull('returned_at')->count();
    }

    /**
     * @param int $transaction_id
     * @return mixed
     */
    public function getTransaction(int $transaction_id){
        $transaction = $this->where("transaction_id",$transaction_id)->first();
        return $transaction;
    }

    /**
     * @param int $transaction_id
     * @param array $attributes
     * @return mixed
     */
    public function updateTransaction(int $transaction_id, array $attributes){
        $transaction = $this->getTransaction($transaction_id);
        if($transaction == null){
            throw new ModelNotFoundException("Cant find transaction");
        }
        $transaction->book_code = $attributes["book_code"];
        $transaction->member_code = $attributes["member_code"];
        $transaction->borrowed_at = $attributes["borrowed_at"];
        $transaction->returned_at = $attributes["returned_at"];
        $transaction->save();

        // Increase the stock of the book
        $book = Book::where('book_code', $attributes["book_code"])->firstOrFail();
        $book->stock = $book->stock + 1;
        $book->save();


        return $transaction;
    }
}
