<?php

namespace App\Http\Controllers;

use App\Events\CommentEvent;
use App\Models\AssignmentResult;
use App\Models\Category;
use App\Models\Comment;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Vacation;
use App\Models\VacationSubCategory;
use App\Traits\ApiResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Sodium\add;

class VacationController extends Controller
{
    use ApiResource;
    public function index(Request $request): JsonResponse
    {
        $data = Vacation::query()
            ->select([
                'id',
                'category_id',
                'company_id',
                'name',
                'description',
                'salary',
            ])
            ->with([
                'company',
                'subCategories' => function($query){
                    $query->with([
                       'locales'
                    ]);
                },
                'lastComment' => function($query){
                    $query->with([
                        'user' => function($query){
                            $query->select([
                                'id',
                                'name',
                                'surname',
                                'email',
                            ]);
                        }
                    ]);
                }
            ])
            ->simplePaginate($request->get('per_page','15'));
        return $this->dataResponse($data);
    }
    public function show($id): JsonResponse
    {
        $data = Vacation::query()
            ->where('id',$id)
            ->with([
                'company',
                'assignment',
                'lastComment' => function($query){
                    $query->with([
                        'user' => function($query){
                            $query->select([
                                'id',
                                'name',
                                'surname',
                                'email',
                            ]);
                        }
                    ]);
                },
            ])->get();
        if(\auth()->user() !== null && \auth()->user()->user_type === User::USER_TYPE_WORKER){
            if(AssignmentResult::query()
                ->where('worker_id', Auth::user()->worker()->value('id'))
                ->value('assignment_id') === $data[0]->assignment_id)
                {
                    $data[0]['applied'] = true;
                }
            else{
                $data[0]['applied'] = false;
            }
        }
        return $this->dataResponse($data);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addComment(Request $request): JsonResponse
    {
        $this->validate($request, $this->validation($this->NEW_COMMENT));
        $comment = Comment::query()->create(
            [
                "comment_content"=>$request->get('content'),
                "user_id"=>auth()->id(),
                "vacation_id"=>$request->get('vacation_id')
            ]
        );
        CommentEvent::dispatch($comment);
        return $this->successResponse('Comment Added Successfully');
    }

    public function showComments(Request $request, $id): JsonResponse
    {
        $data = Comment::query()
            ->where('vacation_id',$id)
            ->with([
                'user' => function($query){
                    $query->select([
                        'id',
                        'name',
                        'surname',
                        'email',
                    ]);
                }
            ])
            ->simplePaginate($request->get('per_page',15));
        return $this->dataResponse($data);
    }

    public function vacationByCategoryId(Request $request, $id): JsonResponse
    {
        $data = Category::query()
            ->findOrFail($id)
            ->with([
                'vacations' => function($query){
                    $query
                        ->select([
                            'id',
                            'category_id',
                            'company_id',
                            'name',
                            'description',
                            'salary',
                        ])
                        ->with([
                        'lastComment' => function($query){
                            $query->with([
                                'user' => function($query){
                                    $query->select([
                                        'id',
                                        'name',
                                        'surname',
                                        'email',
                                    ]);
                                }
                            ]);
                        }
                    ]);
                }
            ])
            ->simplePaginate($request->get('per_page','15'));
        return $this->dataResponse($data);
    }

    public function vacationBySubCategoryId(Request $request, $id): JsonResponse
    {
        $data = VacationSubCategory::query()
            ->where('sub_category_id', $id)
            ->with([
                'vacations' => function($query){
                    $query->with([
                        'lastComment' => function($query){
                            $query->with([
                                'user' => function($query){
                                    $query->select([
                                        'id',
                                        'name',
                                        'surname',
                                        'email',
                                    ]);
                                }
                            ]);
                        }
                    ]);
                }
            ])
            ->simplePaginate($request->get('per_page','15'));
        return $this->dataResponse($data);
    }
}
