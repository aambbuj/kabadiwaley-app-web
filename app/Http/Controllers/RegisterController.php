<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try {

            if($request->user_type == "Admin") {
                $input = $request->all();
                $input['password'] = bcrypt($input['password']);
                $user = User::create($input);
                $success['token'] =  $user->createToken('MyApp')->accessToken;
                $success['user'] =  $user;
           
                return $this->sendResponse($success, 'User register successfully.');
            } else {
                return $this->sendError("You are not sign-up directly .. please use app !!"); 
            }
            
        } catch (\Throwable $th) {
            return $this->sendError("Server Error"); 

        }

    }
     
    public function login(Request $request): JsonResponse
    {
        try {
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password,'user_type' => $request->user_type])){ 
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('MyApp')->accessToken; 
                $success['user'] =  $user;
       
                return $this->sendResponse($success, 'User login successfully.');
            } 
            else{ 
                return $this->sendError('User id and password is wrong !!.');
            } 
        } catch (\Throwable $th) {
            return $this->sendError("Please try once");

        }

    }


    public function loginout(Request $request): JsonResponse
    {
        try {
            if($success = $request->user()->token()->revoke()){ 
                return $this->sendResponse($success, 'User Logout successfully.');
            } 
            else{ 
                return $this->sendError('Not Logout !!.');
            } 
        } catch (\Throwable $th) {
            return $this->sendError("Please try once");

        }

    }


    
    public function loginByUser(Request $request): JsonResponse
    {
        try {
            if($request->phone){ 
                $result = User::where('phone',$request->phone)->first();
                if ($result) {
                    return $this->sendResponse($result, 'Otp send your mobile number .');
                } else {
                    $create = User::create(['phone' => $request->phone, "user_type" => "User" ]);
                    $create["otp"] = 1234;
                    return $this->sendResponse($create, 'Otp send your mobile number .');
                }
            } 
            else{ 
                return $this->sendError("user id and password is wrong !!");
            } 
        } catch (\Throwable $th) {
            return $this->sendError("Please try once");

        }

    }

    public function verifiedOtp(Request $request): JsonResponse
    {
        try {
            if($result = User::where('id',$request->id)->where("user_type","User")->first()){ 
                if ($result && $request->otp == 1234) {

                    $result['token'] =  $result->createToken('MyApp')->accessToken; 
                    return $this->sendResponse($result, 'Otp verified Successfully !!.');
                }else{
                    return $this->sendResponse('', 'Invalid otp');

                }
            } 
            else{ 
                return $this->sendError('otp not found');
            } 
        } catch (\Throwable $th) {
            return $this->sendError("Please try once");

        }

    }
    
}
