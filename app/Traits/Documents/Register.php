<?php

namespace App\Traits\Documents;
  
   /**
        * @OA\Post(
        * path="/auth/register",
        * operationId="Register",
        * tags={"Register"},
        * summary="User Register",
        * description="User Register here",
        *         @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"username","email", "password", "password_confirmation"},
        *               @OA\Property(property="username", type="text"),
        *               @OA\Property(property="email", type="text"),
        *               @OA\Property(property="password", type="password"),
        *               @OA\Property(property="password_confirmation", type="password")
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Register Successfully",
        *          @OA\JsonContent(
        *                @OA\Property(property="success", type="boolean", example="true"),
        *                @OA\Property(property="message", type="text", example=""),
        *                @OA\Property(property="data", type="object", format="object", example={"username":"amosgan","email":"amosgan@gmail.com","status_id":2,"last_login_at":"2022-07-12T01:24:18.553582Z","last_login_ip":"127.0.0.1","id":"1f6868c8-bf8e-4c1a-a926-49f5d908a489","created_at":"2022-07-12T01:24:18.000000Z","status":{"id":2,"name":"active"}}, description=""),
        *          ),
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Content",
        *          @OA\JsonContent(
        *                @OA\Property(property="success", type="boolean", example="false"),
        *                @OA\Property(property="message", type="text", example="password confirmation is different with password field"),
        *                @OA\Property(property="data", type="text", example="null"),
        *                @OA\Property(property="error", type="object", format="text", example={"password_confirmation":"password confirmation is different with password field"}, description=""),
        *          
        *          ),
        *      ),
        * )
        */

    trait Register {

    }