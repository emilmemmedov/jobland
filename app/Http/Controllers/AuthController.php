<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyLocale;
use App\Models\Locale;
use App\Models\User;
use App\Models\Worker;
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
        if($request->get('user_type') === User::USER_TYPE_WORKER){
            $this->validate($request,$this->validation($this->NEW_USER_WORKER));
        }
        else if ($request->get('user_type') === User::USER_TYPE_BUSINESSMAN){
            $this->validate($request,$this->validation($this->NEW_USER_BUSINESSMAN));
        }
        else if ($request->get('user_type') === User::USER_TYPE_ADMIN) {
            $this->validate($request,$this->validation($this->NEW_USER_ADMIN));
        }
        else {
            return $this->errorResponse('type field must be  1,2,3');
        }
        if($request->get('user_type') === User::USER_TYPE_WORKER){
            $worker = Worker::query()->create(
                [
                    'min_salary'=>$request->get('min_salary'),
                    'max_salary'=>$request->get('max_salary'),
                    'description'=>$request->get('description'),
                    'category_id'=>$request->get('category_id')
                ]
            );
        }
        else if($request->get('user_type') === User::USER_TYPE_BUSINESSMAN){
            $company = Worker::query()->create(
                [
                    'company_name'=>$request->get('company_name'),
                    'company_phone'=>$request->get('company_phone'),
                    'company_email'=>$request->get('company_email'),
                ]
            );
        }
        $user = User::query()->create(
            [
                'name'=>$request->get('name'),
                'surname'=>$request->get('surname'),
                'email'=>$request->get('email'),
                'password'=>bcrypt($request->get('password')),
                'phone'=>$request->get('phone'),
                'age'=>$request->get('age'),
                'user_type'=>$request->get('user_type'),
                'worker_id'=>$worker->getAttribute('id'),
                'company_id'=>$company->getAttribute('id')
            ]
        );
        $this->setLocales(new Company(), new CompanyLocale(),$user->getKey(),$request->get('locales'));

    $this->validate($request, $this->validation(User::USER_TYPE_ADMIN));

    }
}
