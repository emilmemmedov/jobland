<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyLocale;
use App\Models\Locale;
use App\Models\User;
use App\Models\Worker;
use App\Traits\ApiResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

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

        return $this->respondWithToken($token,auth()->user()->user_type);
    }
    public function logout(): JsonResponse
    {
        try{
            auth()->logout();
        }
        catch (RouteNotFoundException $e){
            return $this->errorResponse('Token is not correct');
        }

        return response()->json(['message' => 'Successfully logged out']);
    }
    protected function respondWithToken($token,$type): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'user_type'=> $type,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function signup(Request $request): JsonResponse
    {
        $this->validate($request,$this->validation($this->NEW_USER));
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
            $company = Company::query()->create(
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
                'worker_id'=>isset($worker)?$worker->getAttribute('id'):null,
                'company_id'=>isset($company)?$company->getAttribute('id'):null
            ]
        );
        if($request->get('user_type') === 1)
            $this->setLocales(new Company(), new CompanyLocale(),$user->getAttribute('id'),$request->get('locales'));
        return $this->successResponse('User created successfully');
    }
    public function setLocales(Model $parentModel, Model $localeModel, $id, $locales){
        $localeModel->where($parentModel->getForeignKey(),$id)->delete();
        $data = [];
        foreach ($locales as $locale) {
            $data[] = [
                $parentModel->getForeignKey() => $id,
                'locale'=>$locale['locale'],
                'company_description'=> $locale['company_description'] ?? null
            ];
        }
        $localeModel->insert($data);
    }
}
