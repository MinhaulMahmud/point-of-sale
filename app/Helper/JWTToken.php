<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class JWTToken
{
    public static function CreateToken($userEmail,$userID): string
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'Laravel-token',
            'iat' => time(),
            'exp' => time() + 3600,
            'email' => $userEmail,
            'userID' => $userID
        ];
        return JWT::encode($payload, $key, 'HS256');
    }

    public static function PassResetToken($userEmail): string
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'Laravel-token',
            'iat' => time(),
            'exp' => time() + 60*60,
            'email' => $userEmail,
        ];
        return JWT::encode($payload, $key, 'HS256');
    }

    /**
     * Summary of VerifyToken
     * @param mixed $token
     * @return string
     */
    // public static function VerifyToken($token):string
    // {
    //     //try catch exception to avoid error
    //     try {
    //         $key = env('JWT_KEY');
    //         $decode = JWT::decode($token, new Key($key, 'HS256'));
    //         return $decode->email;
    //     }
    //     catch (\Exception $e) {
    //         return 'Unauthorized';
    //     }

    // }
    public static function VerifyTokens($token): string|object
    {
        try {
            $key = env('JWT_KEY');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            // Check if the token is expired
            if ($decoded->exp < time()) {
                return 'TokenExpired';
            }

            return $decoded->email;
        } 
        catch (\Exception $e) {
            return 'Unauthorized';
        }
    }
    public static function VerifyToken($token):string|object
    {
        try {
            if($token==null){
                return 'unauthorized';
            }
            else{
                $key =env('JWT_KEY');
                $decode=JWT::decode($token,new Key($key,'HS256'));
                return $decode;
            }
        }
        catch (Exception $e){
            return 'unauthorized';
        }
    }
}
