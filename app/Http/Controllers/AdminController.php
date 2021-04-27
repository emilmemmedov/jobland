<?php

namespace App\Http\Controllers;

use App\Traits\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    use ApiResource;

    public function addCategory(){
        if(Gate::allows('add-category')){

        }
        else{
            return $this->errorResponse('Not authorization for this action');
        }

    }
}
