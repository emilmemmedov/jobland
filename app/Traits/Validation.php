<?php


namespace App\Traits;


trait Validation
{
    public $NEW_USER = 1;
    public function validation($validated): array
    {
        switch ($validated){
            case $this->NEW_USER:
                return [
                    'name'=>'required|min:2|max:18',
                    'surname'=>'required|min:3|max:28',
                    'email'=>'required|unique:users',
                    'password'=>'required|min:5|max:30',
                    'phone'=>'required',
                    'user_type'=>'required',
                    'category_id'=>'required_if:user_type,2|exists:categories,id',
                    'company_name'=>'required_if:user_type,1',
                    'company_phone'=>'required_if:user_type,1',
                    'company_email'=>'required_if:user_type,1|unique:companies',
                    'locales'=>'required_if:user_type,1'
                ];
        }
    }
}
