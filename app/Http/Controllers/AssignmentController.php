<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Question;
use App\Models\Variant;
use App\Traits\ApiResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AssignmentController extends Controller
{
    use ApiResource;

    public function index(Request $request): JsonResponse
    {
        $data = Assignment::query()
            ->where('company_id', auth()->user()->company()->first()->id)
            ->simplePaginate($request->get('per_page',15));
        return $this->dataResponse($data);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show(Request $request, $id): JsonResponse
    {
        if(Gate::allows('show-assignment', $id)){
            $data = Question::query()
                ->where('assignment_id', $id)
                ->with('variants')
                ->simplePaginate($request->get('per_page',15));
            return $this->dataResponse($data);
        }
        return $this->errorResponse('Your unauthenticated for this action');

    }
    public function updateQuestion(Request $request,$assignment_id, $question_id): JsonResponse
    {
        if(Gate::allows('show-assignment', $assignment_id)){
            if($this->checkQuestion([$assignment_id,$question_id])){
                Question::query()
                    ->where('id',$question_id)
                    ->update([
                        'status'=>$request->get('status'),
                        'question'=>$request->get('question')
                    ]);
                Variant::query()
                    ->where('question_id',$question_id)
                    ->delete();
                foreach ($request['variants'] as $variant){
                    Variant::query()->create([
                        'question_id' => $question_id,
                        'position' => $this->getPositionIdSpecialColumn(new Variant(), new Question(), $question_id),
                        'variant' => $variant['variant'],
                        'satisfied' => $variant['satisfied']
                    ]);
                }
                return $this->successResponse('Questions updated successfully');
            }
        }
        return $this->errorResponse('Your unauthenticated for this action');
    }
    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        $this->authorize('create-assignment');
        $this->validate($request,$this->validation($this->NEW_ASSIGNMENT));

        $assignment = Assignment::query()->create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'company_id'=> auth()->user()->company()->first()->id,
        ]);
        $this->setQuestion($request->get('questions'),$assignment->getAttribute('id'));

        return $this->successResponse('Assignment created successfully');
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request): JsonResponse
    {
        if(Gate::allows('show-assignment',$request->get('assignment_id'))){
            $this->validate($request,$this->validation($this->NEW_QUESTION));
            $this->setQuestion($request->get('questions'),$request->get('assignment_id'));
            return $this->successResponse('Question added successfully');
        }
        return $this->errorResponse('Your unauthenticated for this action');
    }
    public function setQuestion($questions, $id){
        foreach ($questions as $question){
            $questionData = Question::query()->create([
                'status' => $question['status'],
                'question' => $question['question'],
                'assignment_id' => $id,
                'position' => $this->getPositionIdSpecialColumn(new Question(), new Assignment(), $id)
            ]);
            foreach ($question['variants'] as $variant){
                Variant::query()->create([
                    'question_id' => $questionData->getAttribute('id'),
                    'position' => $this->getPositionIdSpecialColumn(new Variant(), new Question(), $questionData->getAttribute('id')),
                    'variant' => $variant['variant'],
                    'satisfied' => $variant['satisfied']
                ]);
            }
        }
    }
    private function checkQuestion($ids): bool
    {
        $questions = Question::query()
            ->where('assignment_id',$ids[0])
            ->pluck('id');
        foreach ($questions as $itemId){
            if((string)$ids[1] === (string)$itemId){
                return true;
            }
        }
        return false;
    }
}
