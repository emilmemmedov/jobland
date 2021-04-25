<?php


namespace App\Traits;


trait Validation
{
    public $NEW_USER = 1;

    public function Validation($validated): array
    {
        switch ($validated){
            case $this->NEW_USER:
                return [
                    'name'=>'required|min:2|max:18',
                    'surname'=>'required|min:3|max:28',
                    'email'=>'required|unique:users',
                    'password'=>'required|min:5|max:30',
                    'phone'=>'required',
                    'age'=>'required',
                    'user_type'=>'required',
                ];
        }
    }
}
