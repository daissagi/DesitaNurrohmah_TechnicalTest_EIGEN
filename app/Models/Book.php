<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Book extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'book_code';
    protected $fillable = ['book_code', 'title', 'author', 'stock', 'created_at', 'updated_at'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @return Book[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getsBook(){
        $books = $this::all();
        return $books;
    }

    public function getBook(){

        $books = $this::where('stock', '>=', 1)->get();

    foreach ($books as $book) {
        echo "Book ({$book->title}) has stock: {$book->stock}\n";
    }
    }

    public function isBorrowed()
    {
        return $this->where('book_code', $this->book_code)->where('stock', '=', 1)->count();
    }
}
