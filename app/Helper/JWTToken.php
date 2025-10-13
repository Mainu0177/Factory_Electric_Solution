<?php
namespace App\Helper;

use Firebase\JWT\JWT;

class JWTToken{
    public static function CreateToken($userEmail, $userId){
        $key = env('JWT_KEY');

        $payload = [
            'iss' => 'laravel-token', // Issuer
            'iat' => time(), // Issued at
            'exp' => time() + 60*24*30, // Expiration time (3 days)
            'userId' => $userId,
            'email' => $userEmail,

        ];
        return JWT::encode($payload, $key, 'HS256');
    }
}
