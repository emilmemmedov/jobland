<?php

namespace App\Http\Controllers;

use App\Models\VacationSubCategory;
use App\Models\Worker;
use App\Models\WorkerSubCategory;
use App\Traits\ApiResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    use ApiResource;
    public function index(Request $request): JsonResponse
    {
        $data = Worker::query()
            ->select([
                'id',
                'category_id',
                'description',
            ])
            ->with([
                'user' => function($query){
                    $query->select([
                        'id',
                        'worker_id',
                        'name',
                        'surname',
                        'email'
                    ]);
                }
            ])
            ->simplePaginate($request->get('per_page','15'));
        return $this->dataResponse($data);
    }

    public function show($id): JsonResponse
    {
        $data = Worker::query()
            ->where('id', $id)
            ->with([
                'user'
            ])
            ->get();
        return $this->dataResponse($data);
    }

    public function workerByCategoryId(Request $request,$id): JsonResponse
    {
        $data = Worker::query()
            ->where('category_id', $id)
            ->select([
                'id',
                'category_id',
                'description',
            ])
            ->with([
                'user' => function($query){
                    $query->select([
                        'id',
                        'worker_id',
                        'name',
                        'surname',
                        'email'
                    ]);
                }
            ])
            ->simplePaginate($request->get('per_page','15'));
        return $this->dataResponse($data);
    }

    public function workerBySubCategoryId(Request $request, $id): JsonResponse
    {
        $data = WorkerSubCategory::query()
            ->where('sub_category_id', $id)
            ->with([
                'user' => function($query){
                    $query->select([
                        'id',
                        'worker_id',
                        'name',
                        'surname',
                        'email'
                    ]);
                }
            ])
            ->simplePaginate($request->get('per_page','15'));
        return $this->dataResponse($data);
    }
}
