<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\User;
use Inertia\Inertia;
use App\Mail\MailOtp;
use App\Helper\JWTToken;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function UserRegistration(Request $request){
        // dd($request->all());
        try {
            $request->validate([
                "name" => "required|",
                "email" => "required|unique:users,email",
                "phone" => "nullable",
                "password" => "required",
            ]);
            $data = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
            ]);
            // return response()->json([
            //     'status' => true,
            //     'message' => 'User Registration successfully',
            //     'data' => $data
            // ]);
            // $data = [
            //     'message' => "User Registration successfully",
            //     'status' => true,
            //     'error' => '',
            // ];
            $data = ['message'=>'User created successfully','status'=>true,'error'=>''];
            return redirect('/login')->with($data);
            // return redirect('/login')->with($data);
        } catch (\Exception $e) {
            // return response()->json([
            //     'status' => false,
            //     'message' => "user registration failed",
            // ]);
            $data = [
                'message' => "User Registration failed",
                'status' => false,
                'error' => '',
            ];
            return redirect('/registration')->with($data);
        }
    } // end user registration method
    public function UserLogin(Request $request){
        try {
            $count = User::where('email', $request->input('email'))->where('password', $request->input('password'))->select('id')->first();
            if($count !== null){
                // $token = JWTToken::CreateToken($request->input('email'), $count->id);
                // return response()->json([
                //     'status' => 'success',
                //     'message' => 'User login successfully',
                //     'token' => $token
                // ],200)->cookie('token', $token, 60*24*30);
                $email = $request->input('email');
                $user_id = $count->id;

                $request->session()->put('email', $email);
                $request->session()->put('user_id', $user_id);

                $data = [
                    'message' => "User login successfully",
                    'status' => true,
                    'error' => '',
                ];
                return redirect('/dashboardPage')->with($data);
            }
        } catch (\Exception $e) {
            // return response()->json([
            //     'status' => 'failed',
            //     'message' => 'User login failed',
            // ]);
            $data = [
                    'message' => "User login failed",
                    'status' => false,
                    'error' => '',
                ];
                return redirect('/login')->with($data);
        }
    }
    public function UserLogout(Request $request){
        return response()->json([
            'status' => 'success',
            'message' => 'User successfully logged out',
        ], 200)->cookie('token', '', -1);
    }

    public function SendOtpCode(Request $request){
        $email = $request->input('email');
        $otp = rand(1000, 9999);
        $count = User::where('email', $email)->count();
        if($count == 1){
            Mail::to($email)->send(new MailOtp($otp));
            User::where('email', $email)->update(['otp' => $otp]);

            $request->session()->put('email', $email);
            $data = [
                'message' => "4 Digit {$otp} OTP sent to your email",
                'status' => true,
                'error' => '',
            ];
        }else{
            $data = [
                'message' => 'Email not found',
                'status' => false,
                'error' => '',
            ];
            return redirect('/send-otp')->with($data);
        }
    }

    public function VerifyOtp(Request $request){
        // $email = $request->input('email');
        $email = $request->session()->get('email', 'default');
        $otp = $request->input('otp');

        $count = User::where('email', $email)->where('otp', $otp)->count();

        if($count == 1){
            User::where('email', $email)->update(['otp' => 0]);
            // $token = JWTToken::CreateTokenForSetPassword($email);

        $request->session()->put('otp_verify', 'yes');


            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'OTP verified successfully',
            // ], 200)->cookie('token', $token, 60*24*30);
            $data = [
                'status' => true,
                'message' => 'OTP verification successfully',
                'error' => '',
            ];
            return redirect('/reset-password')->with($data);
        }else{
            // return response()->json([
            //     'status' => 'failed',
            //     'message' => 'OTP verified failed',
            // ],401);
            $data = [
                'status' => false,
                'message' => 'OTP verification failed',
                'error' => ''
            ];
            return redirect('/login')->with($data);
        }
    }// end method for verify otp

    public function ResetPassword(Request $request){
        try {
            // $email = $request->header('email');
            $email = $request->session()->get('email', 'default');
            $password = $request->input('password');

            $otp_verify = $request->session()->get('otp_verify', 'default');
            if($otp_verify === 'yes'){
                User::where('email', $email)->update(['password' => $password]);
                $request->session()->flush();

                $data = [
                'status' => true,
                'message' => 'Password reset successfully',
                'error' => '',
            ];
                return redirect('/login')->with($data);
            }else{
                $data = [
                'status' => false,
                // 'message' => 'Something went wrong, Please try again later',
                'message' => 'Password does not reset, Please try again later',
                'error' => '',
            ];
                return redirect('/reset-password')->with($data);
            }

            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Password reset successfully',
            // ], 200);
        } catch (\Exception $e) {
            // return response()->json([
            //     'status' => 'failed',
            //     'message' => 'Something went wrong, Please try again later',
            // ],500);
            $data = [
                'status' => false,
                'message' => 'Something went wrong, Please try again later',
                'error' => '',
            ];
                return redirect('/reset-password')->with($data);
        }
    }// end method for reset password

    public function DashboardPage(Request $request){
        try {
            $user = $request->header('email');
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Dashboard data fetched successfully',
            //     'user' => $user,
            // ], 200);
            return Inertia::render('DashboardPage', ['user' => $user]);
        } catch (\Exception $e) {
            // return response()->json([
            //     'status' => 'failed',
            //     'message' => 'Dashboard data fetch failed',
            // ], 500);
        }
    }



    // Front end functionality
    public function LoginPage(){
        return Inertia::render('LoginPage');
    }
    public function RegistrationPage(){
        return Inertia::render('RegistrationPage');
    }
    public function SendOtpPage(){
        return Inertia::render('SendOtpPage');
    }
    public function VerifyOtpPage(){
        return Inertia::render('VerifyOtpPage');
    }
    public function ResetPasswordPage(){
        return Inertia::render('ResetPasswordPage');
    }
}
