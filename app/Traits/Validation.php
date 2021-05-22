<?php


namespace App\Traits;


trait Validation
{
    public $NEW_USER = 1;
    public $NEW_CATEGORY = 2;
    public $NEW_SUB_CATEGORY = 3;
    public $NEW_VACATION = 4;
    public $NEW_COMMENT = 5;
    public $NEW_ASSIGNMENT = 6;
    public $NEW_QUESTION = 7;
    public $VALIDATION_OFFER = 8;
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
                    'company_description'=>'required_if:user_type,1',
                    'locales'=>'required_if:user_type,1',
                    'sub_categories.*.sub_category_id'=>'required_if:user_type,2|exists:sub_categories,id'
                ];
            case $this->NEW_CATEGORY:
                return [
                    'locales'=>'required',
                    'status'=>'required',
                    'sub_categories.*.locales'=>'required',
                    'sub_categories.*.status'=>'required',
                ];
            case $this->NEW_SUB_CATEGORY:
                return [
                    'category_id'=>'required',
                    'locales'=>'required',
                    'status'=>'required',
                ];
            case $this->NEW_VACATION:
                return [
                    'name'=>'required',
                    'description'=>'required',
                    'category_id'=>'required|exists:categories,id',
                    'salary'=>'integer',
                    'min_age'=>'integer',
                    'max_age'=>'integer',
                    'sub_categories.*.sub_category_id'=>'required|exists:sub_categories,id'
                ];
            case $this->NEW_COMMENT:
                return [
                    'vacation_id'=>'required|exists:vacations,id',
                    'content'=>'required'
                ];
            case $this->NEW_ASSIGNMENT:
                return [
                    'title' => 'required',
                    'description' => 'required',
                    'questions' => 'required',
                    'questions.*.status' => 'required|boolean',
                    'questions.*.question' => 'required',
                    'questions.*.variants' => 'required',
                    'questions.*.variants.*.satisfied' => 'required|boolean',
                    'questions.*.variants.*.variant' => 'required',
                ];
            case $this->NEW_QUESTION:
                return [
                    'questions' => 'required',
                    'questions.*.status' => 'required|boolean',
                    'questions.*.question' => 'required',
                    'questions.*.variants' => 'required',
                    'questions.*.variants.*.satisfied' => 'required|boolean',
                    'questions.*.variants.*.variant' => 'required',
                ];
            case $this->VALIDATION_OFFER:
                return [
                    'title' => 'required',
                    'description' => 'required',
                    'language'=>'required',
                    'scheduled' => 'required',
                    'vacation_id'=> 'required|exists:vacations,id',
                    'worker_id'=>'required|exists:workers,id'
                ];
        }
    }
}
