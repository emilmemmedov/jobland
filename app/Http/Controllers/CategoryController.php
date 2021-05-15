<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\ApiResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResource;

    public function index(): \Illuminate\Http\JsonResponse
    {
        $categories = Category::query()
            ->where('status','=','1')
            ->with(['locales','subCategories.locales'])
            ->get();
        return $this->dataResponse($categories);
    }
    public function show($id): \Illuminate\Http\JsonResponse
    {
        $categories = Category::query()
            ->findOrFail($id)
            ->where('id',$id)
            ->with(['locales','subCategories.locales'])
            ->get();
        return $this->dataResponse($categories);
    }
}
