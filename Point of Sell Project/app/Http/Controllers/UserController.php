<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class UserController extends Controller
{
    function LoginPage():View{
        return view('pages.auth.login-page');
    }
    function RegistrationPage():View{
        return view('pages.auth.registration-page');
    }
    function ResetPasswordPage():View{
        return view('pages.auth.reset-pass-page');
    }
    function SendOTPPage():View{
        return view('pages.auth.send-otp-page');
    }
    function VerifyOTPPage():View{
        return view('pages.auth.verify-otp-page');
    }
    function ProfilePage():View{
        return view('pages.dashboard.profile-page');
    }
    function Dashboard():View{
        return view('pages.dashboard.dashboard-page');
    }




    function UserRegistration(Request $request)
    {
        try{
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => $request->input('password'),
            ]);

            return response([
                "status" => "success",
                "message" => "User Created Successfully"
            ]);

        }catch(Exception $e){
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }

    }

    function UserLogin(Request $request){
        $count = User::where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->select('id')->first();

        if($count !== null){
            $token = JWTToken::CreateToken($request->input('email'), $count->id);
            return response()->json([
                "status" => "success",
                "message" => "User Login Successfully",
                "token" => $token
            ]);
        }
        else{
            return response()->json([
                "status" => "error",
                "message" => "Invalid Credentials"
            ]);
        }
    }

    function SendOTP(Request $request)
    {
        $email = $request->input('email');
        $otp = rand(1000,9999);
        $count = User::where('email', '=', $email)->count();

        if($count == 1){
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email', '=', $email)->update(['otp'=>$otp]);

            return response()->json([
                "status" => "Successful",
                "message" => "successfully send otp"
            ]);
        }
        else{
            return response()->json([
                "status" => "error",
                "message" => "Invalid Credentials"
            ]);
        }
    }

    function VerifyOTP(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', '=', $email)
            ->where('otp', '=', $otp)->count();

        if($count == 1){
            User::where('email', '=', $email)->update(['otp'=>'0']);

            $token = JWTToken::CreateTokenPassword($request->input('email'));
            return response()->json([
                "status" => "success",
                "message" => "OTP Successfully verified"
            ])->cookie('token',$token, 60*24*30);
        }
        else{
            return response()->json([
                "status" => "error",
                "message" => "Can't verify OTP"
            ]);
        }

    }

    function PasswordReset(Request $request){
        try {
            $email = $request->header('email');
            $password = $request->input('password');
            User::where('email', '=', $email)->update(['password'=>$password]);
            return response()->json([
                "status" => "success",
                "message" => "Password Reset Successfully"
            ]);

        }
        catch (\Exception $e){
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    function UserLogout(Request $request){
        return redirect('/login-page')->cookie('token',-1);
    }
}
