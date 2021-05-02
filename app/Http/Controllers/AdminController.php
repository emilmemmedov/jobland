<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryLocalesModel;
use App\Models\SubCategory;
use App\Models\SubCategoryLocalesModel;
use App\Traits\ApiResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    use ApiResource;

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function addCategory(Request $request){
        $this->authorize('add-category');

        $category = Category::query()->create(
            [
                "status"=>$request->get('status'),
                "position_id"=>$this->getPositionId(new Category())
            ]
        );
        if($request->get('sub_categories')){
            foreach ($request->get('sub_categories') as $sub){
                $subCategory = SubCategory::query()->create(
                    [
                        "status"=>$sub['status'],
                        "position_id"=>$this->getPositionId(new SubCategory()),
                        "category_id"=>$category->getAttribute('id')
                    ]
                );
                $this->setLocales(new SubCategory(), new SubCategoryLocalesModel(),$subCategory->getAttribute('id'),$sub['locales']);
            }
        }
        $this->setLocales(new Category(), new CategoryLocalesModel(),$category->getAttribute('id'),$request->get('locales'));
        return $this->successResponse('Category created successfully');
    }
    public function setLocales(Model $parentModel, Model $localeModel, $id, $locales){
        $localeModel->where($parentModel->getForeignKey(),$id)->delete();
        $data = [];
        foreach ($locales as $locale) {
            $data[] = [
                $parentModel->getForeignKey() => $id,
                'locale'=>$locale['locale'],
                'name'=> $locale['name'] ?? null
            ];
        }
        $localeModel->insert($data);
    }
}
