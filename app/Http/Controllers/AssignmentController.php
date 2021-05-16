<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Question;
use App\Models\Variant;
use App\Traits\ApiResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    use ApiResource;

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request){
        $this->authorize('create-assignment');
        $this->validate($request,$this->validation($this->NEW_ASSIGNMENT));

        $assignmentData = Assignment::query()->create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'company_id'=> auth()->id()
        ]);

        foreach ($request->get('questions') as $question){
            $questionData = Question::query()->create([
                'status' => $question['status'],
                'question' => $question['question'],
                'assignment_id' => $assignmentData->getAttribute('id'),
                'position' => $this->getPositionIdSpecialColumn(new Question(), new Assignment(), $assignmentData->getAttribute('id'))
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

        return $this->successResponse('Assignment created successfully');
    }
}
