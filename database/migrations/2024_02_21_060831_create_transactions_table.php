<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('transaction_id');
            $table->string('book_code')->index();
            $table->foreign('book_code')->references('book_code')->on('books');
            $table->string('member_code')->index();
            $table->foreign('member_code')->references('member_code')->on('members');
            $table->date('borrowed_at');
            $table->date('returned_at')->nullable();
            $table->timestamps();           
        });

        Schema::table('transactions', function (Blueprint $table) {

            // Foreign keys
            // $table->foreign('book_code')->references('book_code')->on('books')->onDelete('cascade');
            // $table->foreign('member_code')->references('member_code')->on('members')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropForeign(['book_code']);
        Schema::dropForeign(['member_code']);
        Schema::dropIfExists('transactions');
    }
};
