<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Model;

trait Locales
{
    public function setLocales(Model $parentModel, Model $localeModel, $id, $locales){
        $localeModel->where($parentModel->getForeignKey(),$id)->delete();
        $data = [];
        foreach ($locales as $locale) {
            $data[] = [
                $parentModel->getForeignKey() => $id,
                'locale'=>$locale['locale'],
                'company_description'=> $locale['company_description'] ?? null
            ];
        }
        $localeModel->insert($data);
    }
}
