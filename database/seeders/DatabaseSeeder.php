<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Member;
use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Member::create([
            'member_code' => 'M001',
            'name' => 'Angga'
        ]);

        Member::create([
            'member_code' => 'M002',
            'name' => 'Ferry'
        ]);

        Member::create([
            'member_code' => 'M003',
            'name' => 'Putri'
        ]);

        Book::create([
            'book_code' => 'JK-45',
            'title' => 'Harry Potter',
            'author' => 'J.K Rowling',
            'stock' => 1
        ]);

        Book::create([
            'book_code' => 'SHR-1',
            'title' => 'A Study in Scarlet',
            'author' => 'Arthur Conan Doyle',
            'stock' => 1
        ]);

        Book::create([
            'book_code' => 'TW-11',
            'title' => 'Twilight',
            'author' => 'Stephenie Meyer',
            'stock' => 1
        ]);

        Book::create([
            'book_code' => 'HOB-83',
            'title' => 'The Hobbit, or There and Back Again',
            'author' => 'J.R.R. Tolkien',
            'stock' => 1
        ]);

        Book::create([
            'book_code' => 'NRN-7',
            'title' => 'The Lion, the Witch and the Wardrobe',
            'author' => 'C.S. Lewis',
            'stock' => 1
        ]);

        Transaction::create([
            'book_code' => 'TW-11',
            'member_code' => 'M001',
            'borrowed_at' => '2024-02-18',
            'returned_at' => '2024-02-20'
        ]);

        Transaction::create([
            'book_code' => 'JK-45',
            'member_code' => 'M002',
            'borrowed_at' => '2024-02-18',
            'returned_at' => '2024-02-20'
        ]);

        Transaction::create([
            'book_code' => 'HOB-83',
            'member_code' => 'M003',
            'borrowed_at' => '2024-02-11',
            'returned_at' => '2024-02-20'
        ]);

    }
}
