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
        where('password', $request->input('password'))->select('id')->first();

        if($count !== null) {
            //user login -> JWT token Issue
            $token = JWTToken::CreateToken($request->input('email'),$count->id);
            return response()->json([
                'status' => 'success',
                'message' => 'User logged in successfully'], 200)->cookie('token', $token, 1440);

        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 404);
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
                User::where('email', $email)->update(['otp' => 0]);

                //password reset token
                $token = JWTToken::PassResetToken($request->input('email'));
                return response()->json(['status' => 'success', 'message' => 'OTP verified successfully', 'token' => $token], 200);

            

            default:
                return response()->json(['status' => 'error', 'message' => 'Invalid OTP'], 404);
        }
    }
/*// public function ResetPassword(Request $request)
    // {
    //     $email = $request->header('token');
    //     $password = $request->input('password');

    //     User::where('email','=', $email)->update(['password' => $password]);

    //     return response()->json(['status' => 'success', 'message' => 'Password reset successfully'], 200);
    // }*/
    public function ResetPassword(Request $request)
    {
        // Retrieve the email from the 'email' header, which was set in the middleware
        $email = $request->header('email');

        // Retrieve the new password from the request input
        $password = $request->input('password');

        // Update the user's password in the database without hashing
        $updated = User::where('email', '=', $email)->update(['password' => $password]);

        // Check if the password update was successful
        if ($updated) 
        {
            return response()->json(['status' => 'success', 'message' => 'Password reset successfully'], 200);
        } 
        else 
        {
            return response()->json(['status' => 'failed', 'message' => 'Password reset failed'], 400);
        }
    }


    public function LoginPage(){

        return view('pages.auth.login');
    }

    public function RegisterPage(){
        return view('pages.auth.register');
    }

    public function PassresetPage(){
        return view('pages.auth.reset-pass');
    }

    public function ThrowOTP(){
        return view('pages.auth.send-otp');}

    public function ConfirmOTP(){
        return view('pages.auth.verif-otp');}

    public function Dashboard(){
        return view('pages.dashboard.dashboard');
    }

    public function ProfileView(){
        return view('pages.dashboard.profile');
    }
}