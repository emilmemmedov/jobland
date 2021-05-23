<?php

namespace App\Providers;

use App\Models\Assignment;
use App\Models\Question;
use App\Models\User;
use App\Models\Vacation;
use App\Models\Worker;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('add-category',function (User $user){
            if($user->getAttribute('user_type') === User::USER_TYPE_ADMIN){
                return true;
            }
            else{
                return false;
            }
        });
        Gate::define('create-vacation',function (User $user){
            if($user->getAttribute('user_type') === User::USER_TYPE_BUSINESSMAN){
                return true;
            }
            else{
                return false;
            }
        });

        Gate::define('create-assignment',function (User $user){
            if($user->getAttribute('user_type') === User::USER_TYPE_BUSINESSMAN){
                return true;
            }
            else{
                return false;
            }
        });
        Gate::define('apply-vacation',function (User $user){
            if($user->getAttribute('user_type') === User::USER_TYPE_WORKER){
                return true;
            }
            else{
                return false;
            }
        });
        Gate::define('show-assignment',function (User $user,$id){
            if($user->getAttribute('user_type') === User::USER_TYPE_BUSINESSMAN){
                $assignmentIds = Assignment::query()
                    ->where('company_id',\auth()->user()->company->id)
                    ->pluck('id');
                foreach ($assignmentIds as $itemId){
                    if((string)$id === (string)$itemId){
                        return true;
                    }
                }
            }
            return false;
        });

        Gate::define('update-question',function (User $user,$ids){
            if($user->getAttribute('user_type') === User::USER_TYPE_BUSINESSMAN){
                $assignmentIds = Assignment::query()
                    ->where('company_id',\auth()->id())
                    ->pluck('id');
                foreach ($assignmentIds as $itemId){
                    if((string)$ids[0] === (string)$itemId){
                        return $this->checkQuestion($ids);
                    }
                }
            }
            return false;
        });
        Gate::define('interview-offer',function (User $user, $id){
            if($user->getAttribute('user_type') === User::USER_TYPE_BUSINESSMAN){
                $workerIds = Vacation::query()
                    ->where('company_id',\auth()->id())
                    ->pluck('id');
                foreach ($workerIds as $itemId){
                    if((string)$id === (string)$itemId){
                        return true;
                    }
                }
            }
            return false;
        });
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
