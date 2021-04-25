<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'v1'], function (){
    Route::group(['prefix'=>'client'],function (){
        Route::get('category',[\App\Http\Controllers\CategoryController::class,'index']);
        Route::get('category/{id}',[\App\Http\Controllers\CategoryController::class,'show']);

        Route::get('vacation',[\App\Http\Controllers\VacationController::class,'index']);
        Route::get('vacation/{id}',[\App\Http\Controllers\VacationController::class,'show']);
        Route::get('vacation/{id}/comment',[\App\Http\Controllers\VacationController::class,'showComments']);
        Route::get('vacation/category/{id}',[\App\Http\Controllers\VacationController::class,'vacationByCategoryId']);
        Route::get('vacation/subcategory/{id}',[\App\Http\Controllers\VacationController::class,'vacationBySubCategoryId']);

        Route::get('company',[\App\Http\Controllers\CompanyController::class,'index']);
        Route::get('company/{id}',[\App\Http\Controllers\CompanyController::class,'show']);

        Route::get('worker',[\App\Http\Controllers\WorkerController::class,'index']);
        Route::get('worker/{id}',[\App\Http\Controllers\WorkerController::class,'show']);

        //after authenticated

        //------------- For Worker ------------

        Route::get('user',[\App\Http\Controllers\UserController::class,'index']); // both worker and businessman and admin
        Route::put('user/update',[\App\Http\Controllers\UserController::class,'update']); // both worker and businessman and admin

        Route::post('interview/accept',[\App\Http\Controllers\InterviewController::class,'acceptInterview']);
        Route::post('interview/reject',[\App\Http\Controllers\InterviewController::class,'acceptReject']);

        Route::post('vacation/worker/apply',[\App\Http\Controllers\VacationController::class,'applyVacation']);

        Route::get('vacation/for/worker',[\App\Http\Controllers\VacationController::class,'specialVacation']);

        //------------- For Businessman -------------

        Route::post('vacation/create',[\App\Http\Controllers\VacationController::class,'create']);
        Route::delete('vacation/delete/{id}',[\App\Http\Controllers\VacationController::class,'delete']);
        Route::put('vacation/update/{id}',[\App\Http\Controllers\VacationController::class,'update']);

        Route::post('interview/offer',[\App\Http\Controllers\InterviewController::class,'offerInterview']);

        Route::post('vacation/worker/accept',[\App\Http\Controllers\VacationController::class,'acceptVacation']);
        Route::post('vacation/worker/reject',[\App\Http\Controllers\VacationController::class,'rejectVacation']);

        Route::get('worker/for/vacation/{id}',[\App\Http\Controllers\WorkerController::class,'specialWorker']);

    });
});
