<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Member extends Model
{
    protected $table = 'members';
    protected $primaryKey = 'member_code';
    protected $fillable = ['member_code', 'name', 'created_at', 'updated_at'];

    /**
     * @return Member[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getsMember(){
        $members = $this::all();
        return $members;
    }

    // /**
    //  * @param int $id
    //  * @return mixed
    //  */
    // public function BorrowedBooksInfo()
    // {
    //     $members = $this::all();

    //     foreach ($members as $member) {
    //         $booksBorrowedCount = $member->borrowedBooksCount();
    //         echo "Member {$member->name} has borrowed {$booksBorrowedCount} books.\n";
    //     }
    // }

    // public function borrowedBooksCount()
    // {
    //     return $this->transactions->whereNull('returned_at')->count();
    // }

    // public function transactions()
    // {
    //     return $this->hasMany(Transaction::class);
    // } 

    public function transactions()
{
    return $this->hasMany(Transaction::class, 'member_code', 'member_code');
}

}
