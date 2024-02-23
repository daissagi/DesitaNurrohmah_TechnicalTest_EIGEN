<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Book;
use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $transaction;

    public function __construct(Transaction $transaction){
        $this->transaction = $transaction;
    }

    /**
     * Create Transaction
     * @OA\Post (
     *     path="/api/transaction/store",
     *     tags={"Transaction"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="book_code",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="member_code",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="borrowed_at",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="returned_at",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "book_code":"JK-45",
     *                     "member_code":"M001",
     *                     "borrowed_at":"2021-12-11T09:25:53.000000Z",
     *                     "returned_at":"2021-12-11T09:25:53.000000Z"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="transaction_id", type="number", example=1),
     *              @OA\Property(property="book_code", type="string", example="JK-45"),
     *              @OA\Property(property="member_code", type="string", example="M001"),
     *              @OA\Property(property="borrowed_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="returned_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     * *            @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      )
     * )
     */
    public function store(Request $request){
        $transaction = $this->transaction->createTransaction($request->all());
        return response()->json($transaction);
    }

    /**
     * Get List Member
     * @OA\Get (
     *     path="/api/member/getBorrowedBooksInfo",
     *     tags={"Member"},
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="member_code",
     *                         type="string",
     *                         example="M001"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="example name"
     *                     ),
     *                     @OA\Property(
     *                         property="borrowed_book",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2021-12-11T09:25:53.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2021-12-11T09:25:53.000000Z"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getBorrowedBooksInfo(){
        $transactions = $this->transaction->BorrowedBooksInfo();
        return response()->json(["rows"=>$transactions]);
    }

    /**
     * Update Transaction
     * @OA\Put (
     *     path="/api/transaction/update/{transaction_id}",
     *     tags={"Transaction"},
     *     @OA\Parameter(
     *         in="path",
     *         name="transaction_id",
     *         required=true,
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="transaction_id",
     *                          type="number"
     *                      ),
     *                      @OA\Property(
     *                          property="book_code",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="member_code",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="borrowed_at",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="returned_at",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "transaction_id":"1",
     *                     "book_code":"AB-12"
     *                     "member_code":"M000",
     *                     "borrowed_at":"2021-12-11",
     *                      "returned_at":"2021-12-15"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="transaction_id", type="number", example=1),
     *              @OA\Property(property="book_code", type="string", example="AB-12"),
     *              @OA\Property(property="member_code", type="string", example="M000"),
     *              @OA\Property(property="borrowed_at", type="string", example="2021-12-11"),
     *              @OA\Property(property="returned_at", type="string", example="2021-12-15"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z")
     *          )
     *      )
     * )
     */
    public function update($transaction_id, Request $request){
        try {
            $transactions = $this->transaction->updateTransaction($transaction_id,$request->all());
            return response()->json($transactions);
        }catch (ModelNotFoundException $exception){
            return response()->json(["msg"=>$exception->getMessage()],404);
        }
    }
}
