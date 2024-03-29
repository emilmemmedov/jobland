<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacationApplyController;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\WorkerController;
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
        Route::get('category',[CategoryController::class,'index']); //done
        Route::get('category/{id}',[CategoryController::class,'show']); //done

        Route::get('vacation',[VacationController::class,'index']); //done
        Route::get('vacation/{id}',[VacationController::class,'show']); //done
        Route::get('vacation/{id}/comment',[VacationController::class,'showComments']); //done
        Route::get('vacation/category/{id}',[VacationController::class,'vacationByCategoryId']);//done
        Route::get('vacation/subcategory/{id}',[VacationController::class,'vacationBySubCategoryId']); //done

        Route::get('company',[CompanyController::class,'index']); //done
        Route::get('company/{id}',[CompanyController::class,'show']); //done

        Route::get('worker',[WorkerController::class,'index']); //done
        Route::get('worker/{id}',[WorkerController::class,'show']);//done
        Route::get('worker/category/{id}',[WorkerController::class,'workerByCategoryId']); //done
        Route::get('worker/subcategory/{id}',[WorkerController::class,'workerBySubCategoryId']);//done


        //------------------------------- AUTHENTICATE START ------------------------------------
        Route::post('login',[AuthController::class,'login'])->name('login');//done
        Route::post('signup',[AuthController::class,'signup']);//done
        Route::post('logout',[AuthController::class,'logout']); //done
        Route::post('refresh',[AuthController::class,'refresh']); //done
        //-------------------------------- AUTHENTICATE END ------------------------------------

        //------------- For Worker ------------
        Route::group(['middleware'=>'auth:api'],function (){
            Route::get('user',[UserController::class,'index']); // both worker and businessman and admin
            Route::put('user/update',[UserController::class,'update']); // both worker and businessman and admin

            Route::post('interview/accept', [InterviewController::class,'acceptInterview']);

            Route::post('vacation/apply', [AssignmentController::class,'applyVacation']);//done
            Route::get('vacation/assignment/{id}', [AssignmentController::class,'getQuestion']);
            Route::post('vacation/assignment/{id}', [AssignmentController::class,'answerQuestion']);

            Route::get('vacation/for/worker',[WorkerController::class,'specialVacations']);
            Route::post('vacation/add/comment', [VacationController::class,'addComment']); //done

            Route::get('message/company/{id}',[WorkerController::class,'showMessages']);
            Route::post('message/company',[WorkerController::class,'sendMessage']);

            //------------- For Businessman -------------
            Route::post('assignment', [AssignmentController::class,'create']); //done
            Route::put('assignment', [AssignmentController::class,'update']); //done
            Route::get('assignment', [AssignmentController::class,'index']);//done
            Route::get('assignment/{id}', [AssignmentController::class,'show']);//done
            Route::put('assignment/{assignment_id}/question/{question_id}',[AssignmentController::class,'updateQuestion']);//done

            Route::post('vacation/create',[CompanyController::class,'createVacation']); //done
            Route::delete('vacation/delete/{id}',[CompanyController::class,'deleteVacation']); //done
            Route::put('vacation/update/{id}',[CompanyController::class,'updateVacation']); //done

            Route::get('interview',[InterviewController::class, 'index']);
            Route::get('interview/{id}',[InterviewController::class,'show']);
            Route::put('interview/{id}', [InterviewController::class, 'update']);
            Route::post('interview/offer', [InterviewController::class,'offerInterview']);
            Route::post('interview/reject', [InterviewController::class,'rejectInterview']);

            Route::get('worker/for/vacation/{id}',[CompanyController::class,'specialWorker']);

            Route::get('message/worker/{id}',[CompanyController::class,'showMessages']);
            Route::post('message/worker',[CompanyController::class,'sendMessage']);
        });

    });

//    \Illuminate\Support\Facades\Auth::routes();

    Route::group(['prefix'=>'admin','middleware'=>'auth:api'],function (){
        //authenticated admin
        Route::post('add/category',[AdminController::class,'addCategory']); //done
        Route::post('add/subcategory',[AdminController::class,'addSubCategory']); //done
    });
});
