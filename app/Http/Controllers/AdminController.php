<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryLocalesModel;
use App\Traits\ApiResource;
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

        Category::query()->create(
            [
                "status"=>$request->get('status'),
            ]
        );
        $this->setLocales(new Category(), new CategoryLocalesModel());
    }
}
