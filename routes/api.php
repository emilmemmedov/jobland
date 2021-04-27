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


        //------------------------------- AUTHENTICATE START ------------------------------------
        Route::post('login',[\App\Http\Controllers\AuthController::class,'login'])->name('login');//done
        Route::post('signup',[\App\Http\Controllers\AuthController::class,'signup']);//done
        Route::post('logout',[\App\Http\Controllers\AuthController::class,'logout']); //done
        Route::post('refresh',[\App\Http\Controllers\AuthController::class,'refresh']);
        //-------------------------------- AUTHENTICATE END ------------------------------------

        //------------- For Worker ------------

        Route::get('user',[\App\Http\Controllers\UserController::class,'index']); // both worker and businessman and admin
        Route::put('user/update',[\App\Http\Controllers\UserController::class,'update']); // both worker and businessman and admin

        Route::post('interview/accept',[\App\Http\Controllers\InterviewController::class,'acceptInterview']);
        Route::post('interview/reject',[\App\Http\Controllers\InterviewController::class,'acceptReject']);
        Route::delete('interview/delete/{id}',[\App\Http\Controllers\InterviewController::class,'deleteInterview']);
        Route::post('resign/company/{id}',[\App\Http\Controllers\WorkerController::class,'resignCompany']);

        Route::post('vacation/worker/apply',[\App\Http\Controllers\VacationApplyController::class,'applyVacation']);
        Route::delete('vacation/worker/delete/{id}',[\App\Http\Controllers\VacationApplyController::class,'deleteApplyVacation']);

        Route::get('vacation/for/worker',[\App\Http\Controllers\WorkerController::class,'specialVacations']);

        Route::get('message/company/{id}',[\App\Http\Controllers\WorkerController::class,'showMessages']);
        Route::post('message/company',[\App\Http\Controllers\WorkerController::class,'sendMessage']);

        //------------- For Businessman -------------


        Route::post('vacation/create',[\App\Http\Controllers\CompanyController::class,'createVacation']);
        Route::delete('vacation/delete/{id}',[\App\Http\Controllers\CompanyController::class,'deleteVacation']);
        Route::put('vacation/update/{id}',[\App\Http\Controllers\CompanyController::class,'updateVacation']);

        Route::post('interview/offer',[\App\Http\Controllers\InterviewController::class,'offerInterview']);
        Route::delete('interview/delete/{id}',[\App\Http\Controllers\InterviewController::class,'deleteInterview']);
        Route::post('accept/worker',[\App\Http\Controllers\CompanyController::class,'acceptWorker']);
        Route::post('reject/worker',[\App\Http\Controllers\CompanyController::class,'rejectWorker']);
        Route::post('resign/worker/{id}',[\App\Http\Controllers\CompanyController::class,'resignWorker']);

        Route::post('vacation/worker/accept',[\App\Http\Controllers\VacationApplyController::class,'acceptVacation']);
        Route::post('vacation/worker/reject',[\App\Http\Controllers\VacationApplyController::class,'rejectVacation']);
        Route::delete('vacation/worker/delete/{id}',[\App\Http\Controllers\VacationApplyController::class,'deleteApplyVacation']);

        Route::get('worker/for/vacation/{id}',[\App\Http\Controllers\CompanyController::class,'specialWorker']);

        Route::get('message/worker/{id}',[\App\Http\Controllers\CompanyController::class,'showMessages']);
        Route::post('message/worker',[\App\Http\Controllers\CompanyController::class,'sendMessage']);
    });

//    \Illuminate\Support\Facades\Auth::routes();

    Route::group(['prefix'=>'admin','middleware'=>'auth:api'],function (){
        //authenticated admin
        Route::post('add/category',[\App\Http\Controllers\AdminController::class,'addCategory']);
        Route::post('add/subCategory',[\App\Http\Controllers\AdminController::class,'addSubCategory']);
    });
});
