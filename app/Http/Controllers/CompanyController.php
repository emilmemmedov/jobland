<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Vacation;
use App\Models\VacationSubCategory;
use App\Traits\ApiResource;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Gate;

class CompanyController extends Controller
{
    use ApiResource;

    public function index(Request $request): JsonResponse
    {
        $data = Company::query()
            ->select([
                'id',
                'company_name',
                'company_email',
                'company_icon'
            ])
            ->with('locales')
            ->simplePaginate($request->get('per_page','15'));
        return $this->dataResponse($data);
    }

    public function show($id): JsonResponse
    {
        $data = Company::query()
            ->findOrFail($id)
            ->with([
                'locales',
                'user' => function($query){
                    $query->select([
                        'id',
                        'name',
                        'surname',
                        'email',
                        'company_id',
                        'phone'
                    ]);
                }
            ])
            ->get();
        return $this->dataResponse($data);
    }
    /**
     * @throws AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createVacation(Request $request): JsonResponse
    {
        $this->authorize('create-vacation');
        if($request->get('assignment_id') === null || Gate::allows('show-assignment', $request->get('assignment_id'))){
            $this->validate($request,$this->validation($this->NEW_VACATION));
            $vacation = Vacation::query()->create(
                [
                    "name"=>$request->get('name'),
                    "description"=>$request->get('description'),
                    "salary"=>$request->get('salary'),
                    "min_age"=>$request->get('min_age'),
                    "max_age"=>$request->get('max_age'),
                    "expire_time"=> Carbon::now()->addDays(30),
                    "category_id"=>$request->get('category_id'),
                    "company_id"=>auth()->id(),
                    'assignment_id'=>$request->get('assignment_id')
                ]
            );
            if(is_array($request->get('sub_categories')) && count($request->get('sub_categories')))
            {
                foreach ($request->get('sub_categories') as $subcategory){
                    VacationSubCategory::query()->create([
                        'vacation_id' => $vacation->getAttribute('id'),
                        'sub_category_id' => $subcategory['sub_category_id']
                    ]);
                }
            }
            return $this->successResponse('Vacation created Successfully');
        }
        return $this->errorResponse('Your unauthenticated for this action');
    }

    /**
     * @throws AuthorizationException
     */
    public function deleteVacation($id): JsonResponse
    {
        $this->authorize('create-vacation');

        Vacation::query()->findOrFail($id)->delete();
        return $this->successResponse('Vacation delete Successfully');
    }

    /**
     * @throws AuthorizationException
     */
    public function updateVacation(Request $request,$id): JsonResponse
    {
        $this->authorize('create-vacation');
        if($request->get('assignment_id') === null || Gate::allows('show-assignment', $request->get('assignment_id'))){
            Vacation::query()->findOrFail($id)->update($request->only([
                'name',
                'description',
                'salary',
                'min_age',
                'max_age',
                'category_id',
                'expire_time',
                'assignment_id'
            ]));
        }
        return $this->errorResponse('Your unauthenticated for this action');
    }
}
