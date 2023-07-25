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
                $success['name'] =  $user->name;
           
                return $this->sendResponse($success, 'User register successfully.');
            } else {
                return $this->sendError("Validation Error.", "You are not sign-up directly .. please use app !!"); 
            }
            
        } catch (\Throwable $th) {
            return $this->sendError($th, "Server Error"); 

        }

    }
     
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        try {
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password,'user_type' => $request->user_type])){ 
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('MyApp')->accessToken; 
                $success['name'] =  $user->name;
       
                return $this->sendResponse($success, 'User login successfully.');
            } 
            else{ 
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            } 
        } catch (\Throwable $th) {
            return $this->sendError('server error.', "Please try once");

        }

    }
    public function loginByUser(Request $request): JsonResponse
    {
        try {
            if($request->phone){ 
                $result = User::where('phone',$request->phone)->first();
                if ($result) {
                    return $this->sendResponse($result, 'Already sign-up , please go to next option.');
                } else {
                    $create = User::create(['phone' => $request->phone, "user_type" => "User" ]);
                    $create["otp"] = 1234;
                    return $this->sendResponse($create, 'User sign-up successfully .');
                }
            } 
            else{ 
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            } 
        } catch (\Throwable $th) {
            return $this->sendError($th, "Please try once");

        }

    }

    public function verifiedOtp(Request $request): JsonResponse
    {
        try {
            if($result = User::where('id',$request->id)->first()){ 
                if ($result) {
                    $result['token'] =  $result->createToken('MyApp')->accessToken; 
                    return $this->sendResponse($result, 'Already sign-up , please go to next option.');
                }
            } 
            else{ 
                return $this->sendError('Unauthorised.', 'otp not found');
            } 
        } catch (\Throwable $th) {
            return $this->sendError($th, "Please try once");

        }

    }

    
}
