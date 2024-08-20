<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPMail;


class UserController extends Controller
{

    public function UserRegister(Request $request)
    {
        #try catch block
        try {
            User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'password' => $request->input('password'),
            ]);
    
            return response()->json(['status' => 'success', 'message' => 'User created successfully'], 201);
        }
        catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 500);
        }
        
    }

    public function UserLogin(Request $request)
    {
        $count =User::where('email', $request->input('email'))->
        where('password', $request->input('password'))->count();

        if($count == 1) {
            //user login -> JWT token Issue
            $token = JWTToken::CreateToken($request->input('email'));
            return response()->json(['status' => 'success', 'message' => 'User logged in successfully', 'token' => $token], 200);

        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 200);
        }
    }
    function SendOTP(Request $request)
    {   
        $email = $request->input('email');
        $otp = rand(1000,9999);
        
        $count = User::where('email','=', $email)->count();

        switch ($count) {
            case 1:
                Mail::to($email)->send(new OTPMail($otp));

                //update otp in database
                User::where('email', $email)->update(['otp' => $otp]);
                return response()->json(['status' => 'success', 'message' => 'OTP sent successfully'], 200);
            default:
                return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }
    }

    function VerifyOTP(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email','=', $email)->where('otp','=', $otp)->count();

        switch ($count==1) {
            case 1:
                //update otp in database
                User::where('email', $email)->update(['otp' => null]);

                //password reset token
                $token = JWTToken::PassResetToken($request->input('email'));
                return response()->json(['status' => 'success', 'message' => 'OTP verified successfully', 'token' => $token], 200);

            

            default:
                return response()->json(['status' => 'error', 'message' => 'Invalid OTP'], 404);
        }
    }

    function ResetPassword(Request $request)
    {
        $email = $request->header('token');
        $password = $request->input('password');

        User::where('email','=', $email)->update(['password','=', $password]);

        return response()->json(['status' => 'success', 'message' => 'Password reset successfully'], 200);
    }
}