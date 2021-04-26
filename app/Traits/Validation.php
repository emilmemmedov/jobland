<?php


namespace App\Traits;


trait Validation
{
    public $NEW_USER_WORKER = 1;
    public $NEW_USER_BUSINESSMAN= 2;
    public $NEW_USER_ADMIN = 3;

    public function validation($validated): array
    {
        switch ($validated){
            case $this->NEW_USER_WORKER:
                return [
                    'name'=>'required|min:2|max:18',
                    'surname'=>'required|min:3|max:28',
                    'email'=>'required|unique:users',
                    'password'=>'required|min:5|max:30',
                    'phone'=>'required',
                    'user_type'=>'required',
                    'category_id'=>'required'
                ];
            case $this->NEW_USER_BUSINESSMAN:
                return [
                    'name'=>'required|min:2|max:18',
                    'surname'=>'required|min:3|max:28',
                    'email'=>'required|unique:users',
                    'password'=>'required|min:5|max:30',
                    'phone'=>'required',
                    'user_type'=>'required',
                    'company_name'=>'required',
                    'company_phone'=>'required',
                    'company_email'=>'required',
                    'locales'=>'required'
                ];
        }
    }
}
