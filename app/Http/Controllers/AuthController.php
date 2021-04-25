<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResource;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','signup']]);
    }

    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function signup(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),$this->Validation($this->NEW_USER));
        if($validator->fails()){
            return $this->errorResponse($validator->errors());
        }

        User::create(
            [
                'name'=>$request->get('name'),
                'surname'=>$request->get('surname'),
                'email'=>$request->get('email'),
                'password'=>bcrypt($request->get('password')),
                'phone'=>$request->get('phone'),
            ]
        );
    }
}
