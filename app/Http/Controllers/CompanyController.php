<?php

namespace App\Http\Controllers;

use App\Models\Vacation;
use App\Models\VacationSubCategory;
use App\Traits\ApiResource;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class CompanyController extends Controller
{
    use ApiResource;

    /**
     * @throws AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createVacation(Request $request): JsonResponse
    {
        $this->authorize('create-vacation');
        $this->validate($request,$this->validation($this->NEW_VACATION));
        // date('Y/m/d h:i:s',strtotime(date('Y/m/d h:i:s').'+ 30 days'));
        $vacation = Vacation::query()->create(
            [
                "name"=>$request->get('name'),
                "description"=>$request->get('description'),
                "salary"=>$request->get('salary'),
                "min_age"=>$request->get('min_age'),
                "max_age"=>$request->get('max_age'),
                "expire_time"=> Carbon::now()->addDays(30),
                "category_id"=>$request->get('category_id'),
                "company_id"=>auth()->id()
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
        Vacation::query()->find($id)->update($request->only([
            'name',
            'description',
            'salary',
            'min_age',
            'max_age',
            'category_id',
            'expire_time'
        ]));
        return $this->successResponse('Vacation updated Successfully');
    }
}
