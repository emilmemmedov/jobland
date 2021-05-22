<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\Question;
use App\Traits\ApiResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InterviewController extends Controller
{
    use ApiResource;

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function offerInterview(Request $request): JsonResponse
    {
        if(Gate::allows('interview-offer', $request->get('vacation_id'))){
            $this->validate($request,$this->validation($this->VALIDATION_OFFER));
            Interview::query()
                ->create([
                   'title' => $request->get('title'),
                    'description' => $request->get('description'),
                    'language' => $request->get('language'),
                    'scheduled' => $request->get('scheduled'),
                    'company_id' => auth()->user()->company()->first()->id,
                    'vacation_id' => $request->get('vacation_id'),
                    'status_id' => Interview::CREATED,
                ]);
        }
        return $this->errorResponse('Your unauthenticated for this action');
    }
}
