<?php

namespace App\Traits\Documents;
        /**
        *   #########################
        *     Stock Payment Method
        *   #########################
        * 
        *   @OA\Get(
        *      path="/stock/payment_method",
        *      operationId="payment_method",
        *      tags={"Stock"},
        *      summary="a list of method for payment",
        *      description="This identifier is required for payment completion and is sent along with the credit/debit card number",
        *      @OA\Response(
        *          response=200,
        *          description="Successful get a list of payment method",
        *          @OA\JsonContent(
        *                @OA\Property(property="success", type="boolean", example="true"),
        *                @OA\Property(property="message", type="text", example=""),
        *                @OA\Property(property="data", type="object", format="object", example={{"id":1,"name":"debit_card"},{"id":2,"name":"credit_card"}}, description=""),
        *          ),
        *       ),
        *   ),
        * 
        *   ###############
        *     Stock List
        *   ###############
        * 
        *   @OA\Get(
        *      path="/stock",
        *      operationId="stock_list",
        *      tags={"Stock"},
        *      summary="a list of published goods by seller",
        *      description="A marketplace for buyer who wanting to buy a game key",
        *      @OA\Response(
        *          response=200,
        *          description="Successful get a list of goods",
        *          @OA\JsonContent(
        *                @OA\Property(property="success", type="boolean", example="true"),
        *                @OA\Property(property="message", type="text", example=""),
        *                @OA\Property(property="data", type="object", format="object", example={{"id":1,"user_id":"67cb6cce-2d93-4fd9-ab86-c4b22d157766","code":"GNM123312","status_id":8,"price":1000000,"description":"Steam Wallet Code RM10 MY","created_at":"2022-07-11T05:48:46.000000Z","status":{"id":8,"name":"published"}},{"id":2,"user_id":"67cb6cce-2d93-4fd9-ab86-c4b22d157766","code":"GNM1233123","status_id":8,"price":5000000,"description":"Steam Wallet Code RM50 MY","created_at":"2022-07-11T05:49:22.000000Z","status":{"id":8,"name":"published"}}}, description=""),
        *          ),
        *       ),
        *   ),
        * 
        *   ###############
        *      Add Stock
        *   ###############
        * 
        *   @OA\Post(
        *   path="/stock",
        *   operationId="add",
        *   tags={"Stock"},
        *   summary="Sell game key through the marketplace",
        *   description="A person received game keys from a game distribution platform who is eager to sell them through the marketplace",
        *         @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"user_id", "code", "price", "description"},
        *               @OA\Property(property="user_id", type="uuid"),
        *               @OA\Property(property="code", type="alphanumeric"),
        *               @OA\Property(property="price", type="integer"),
        *               @OA\Property(property="description", type="text")
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Publish goods to marketplace successfully",
        *          @OA\JsonContent(
        *                @OA\Property(property="success", type="boolean", example="true"),
        *                @OA\Property(property="message", type="text", example="goods published"),
        *                @OA\Property(property="data", type="object", format="object", example={"user_id":"67cb6cce-2d93-4fd9-ab86-c4b22d157766","price":"5000000","status_id":8,"description":"Steam Wallet Code RM50 MY","created_at":"2022-07-12T01:37:17.000000Z","id":7,"status":{"id":8,"name":"published"}}, description=""),
        *          ),
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Content",
        *          @OA\JsonContent(
        *                @OA\Property(property="success", type="boolean", example="false"),
        *                @OA\Property(property="message", type="text", example="The code field is required"),
        *                @OA\Property(property="data", type="text", example="null"),
        *                @OA\Property(property="error", type="object", format="text", example={"code":"The code field is required.","price":"The price field is required."}, description=""),
        *          
        *          ),
        *      ),
        * )
        *   
        * ###############
        * Purchase Stock
        * ###############
        *
        * @OA\Post(
        * path="/stock/purchase",
        * operationId="purchase",
        * tags={"Stock"},
        * summary="Buyer purchase game key",
        * description="A person wanting to buy a game key",
        *         @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"stock_id", "email", "price", "payment_method_id", "card_number", "card_holder_name", "card_cvv"},
        *               @OA\Property(property="stock_id", type="integer", description="id from stock list"),
        *               @OA\Property(property="email", type="email"),
        *               @OA\Property(property="price", type="integer", description="price amount from the goods purchase"),
        *               @OA\Property(property="payment_method_id", type="integer", description="id from payment method list"),
        *               @OA\Property(property="card_number", type="text"),
        *               @OA\Property(property="card_holder_name", type="text"),
        *               @OA\Property(property="card_cvv", type="integer"),

        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Publish goods to marketplace successfully",
        *          @OA\JsonContent(
        *                @OA\Property(property="success", type="boolean", example="true"),
        *                @OA\Property(property="message", type="text", example="goods published"),
        *                @OA\Property(property="data", type="object", format="object", example={"payment":{"email":"jinqgan@gmail.com","order_no":"34379e020324fb2ecfb8432342823e7e","payment_method_id":"2","stock_id":"7","status_id":13,"details":{"card_number":"4534 9128 9647 3231","card_holder_name":"gan gan","card_cvv":"563"},"created_at":"2022-07-12T07:28:19.000000Z","id":5,"status":{"id":13,"name":"pending"}},"stock":{"id":7,"price":5000000,"status_id":12,"status":{"id":12,"name":"pending_payment"}}}, description=""),
        *          ),
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Content",
        *          @OA\JsonContent(
        *                @OA\Property(property="success", type="boolean", example="false"),
        *                @OA\Property(property="message", type="text", example="card number is invalid"),
        *                @OA\Property(property="data", type="text", example="null"),
        *                @OA\Property(property="error", type="object", format="text", example={"card_number":"card number is invalid","card_cvv":"card cvv must be 3 digit"}, description=""),
        *          
        *          ),
        *      ),
        * )
        *          
        * ###############
        * Payment Stock
        * ###############
        *
        * @OA\Post(
        * path="/stock/payment",
        * operationId="payment",
        * tags={"Stock"},
        * summary="Buyer make payment for the good purchase",
        * description="Records with information about the buyer, goods and payment amount",
        *         @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"order_no", "status"},
        *               @OA\Property(property="order_no", type="alphanumeric", description="unique order number generate from purchase response"),
        *               @OA\Property(property="status", type="text", description="status in pending, success, failed"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Goods payment successfully",
        *          @OA\JsonContent(
        *                @OA\Property(property="success", type="boolean", example="true"),
        *                @OA\Property(property="message", type="text", example="update payment successfully"),
        *                @OA\Property(property="data", type="object", format="object", example={"payment":{"id":5,"user_id":null,"email":"jinqgan@gmail.com","order_no":"34379e020324fb2ecfb8432342823e7e","payment_method_id":2,"stock_id":7,"status_id":14,"details":{"card_number":"4534 9128 9647 3231","card_holder_name":"gan gan","card_cvv":"563"},"created_at":"2022-07-12T07:28:19.000000Z","status":{"id":14,"name":"success"}}}, description=""),
        *          ),
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Content",
        *          @OA\JsonContent(
        *                @OA\Property(property="success", type="boolean", example="false"),
        *                @OA\Property(property="message", type="text", example="order not found"),
        *                @OA\Property(property="data", type="text", example="null"),
        *                @OA\Property(property="error", type="object", format="text", example={"order_no":"order not found","status":"status must be either one [pending, success, failed]"}, description=""),
        *          ),
        *      ),
        * )
        */
    trait Stock {
        
    }