<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    // Page Function
    
    function LoginPage(){
        return view('pages.auth.login-page');
    }

    function RegistrationPage(){
        return view('pages.auth.registration-page');
    }

    function SendOtpPage(){
        return view('pages.auth.send-otp-page');
    }

    function VerifyOtpPage(){
       
        return view('pages.auth.verify-otp-page');
    }

    function ResetPassPage(){
        return view('pages.auth.reset-pass-page');
    }

    function DashboardPage(){
        return view('pages.dashboard.dashboard-page');
    }


    // API Function 

    function UserRegistration(Request $request){
        try{
            User::create([
                "firstName" => $request->input("firstName"),
                "lastName" => $request->input('lastName'),
                "email" => $request->input('email'),
                "mobile" => $request->input('mobile'),
                "password" => $request->input('password')
            ]);

            return response()->json([
                'status' => "success",
                'message' => 'User Registraton successfully'
            ],status:200);

        }
        catch(Exception $e){
            return response()->json([
                'status' => "failed",
                'message' => 'User Registraton failed',
                'what error' => $e->getMessage()
            ]);
        }

    }

    function UserLogin(Request $request){
        // $count = User::where('email', '=', $request->input('email'))
        // ->where('password', '=', $request->input('password'))
        // ->count();

        $count = User::where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->count();

        if($count == 1){
            // $token = JWTToken::CreateToken($request->input('email'));
            $token = JWTToken::CreateToken($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'User Login Successful',
                'token' => $token
            ],status:200)->cookie('token',$token,60*24*30);
        }
        
        
        else{
            return response()->json([
            'status' => 'failed',
            'message' => "Unauthorized"
            ]);
        }
    }


    function SendOTP(Request $request){
       $email = $request->input('email');
       $otp = rand(1000, 9999);
       $count = User::where('email', '=', $email)->count();

       if($count == 1){
        // Otp Email Address
        Mail::to($email)->send(new OTPMail($otp));

        // Otp code Update
        User::where('email', '=', $email)->update(['otp' => $otp]);

        return response()->json([
            'status' => "success",
            'message' => '4 digit otp code has been send your email'
        ],status:200);
       }
       else{
        return response()->json([
            'status' => 'failed',
            'message' => 'Unauthorized'
        ]);
       }
    }

    function VerifyOTP(Request $request){
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', '=', $email)
        ->where('otp', '=', $otp)->count();

        if($count == 1){
            // Database otp update
            User::where('email', '=', $email)->update(['otp'=> '0']);

            // pass reset token issue
            $token=JWTToken::CreateTokenForSetPassword($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'OTP Verification Successful',
                'token' => $token
            ],status:200)->cookie('token',$token,60*24*60);
        }
        else{
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ]);
        }
    }


    function ResetPass(Request $request){
        try{
            $email = $request->header('email');
            $password = $request->input('password');
            User::where('email', '=', $email)->update(['password' => $password]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful'
            ],status:200);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'feaild',
                "message" => 'Request is Feail'
            ]);
        }
        
    }


    function UserLogOut(Request $request){
        return redirect("/userLogin")->cookie('token','', -1);
    }

  




}
