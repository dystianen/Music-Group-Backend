<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    // LOGIN
    public $response;
    public function __construct(){
        $this->response = new ResponseHelper();
    }
    
    public function login(Request $request){
		$credentials = $request->only('email', 'password');

		try {
			if(!$token = JWTAuth::attempt($credentials)){
                return $this->response->errorResponse('Invalid email and password');
			}
		} catch(JWTException $e){
            return $this->response->errorResponse('Generate Token Failed');
		}

        $data = [
			'token' => $token,
			'user'  => JWTAuth::user()
		];
        return $this->response->successResponseData('Authentication success', $data);
	}

	public function loginCheck(){
		try {
			if(!$user = JWTAuth::parseToken()->authenticate()){
				return $this->response->errorResponse('Invalid token!');
			}
		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
			return $this->response->errorResponse('Token expired!');
		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
			return $this->response->errorResponse('Invalid token!');
		} catch (Tymon\JWTAuth\Exceptions\JWTException $e){
			return $this->response->errorResponse('Token absent!');
		}
		
		return $this->response->successResponseData('Authentication success!', $user);
	}

	// REGISTER

	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'email' => 'required|string|max:50|unique:Users',
			'password' => 'required|string|min:3',
		]);

		if($validator->fails()){
            return $this->response->errorResponse($validator->errors());
		}

		$user = new User();
		$user->name = $request->name;
		$user->email = $request->email;
		$user->password = Hash::make($request->password);
		$user->save();

		$token = JWTAuth::fromUser($user);

        $data = User::where('email','=', $request->email)->first();
        return $this->response->successResponseData('Anda berhasil registrasi', $data);
	}
}
