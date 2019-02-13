<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarSubModel extends Model
{
    protected $table = 'car_sub_models';

    public function models()
    {
        return $this->belongsToMany('App\CarModel','models_submodels','submodel_id','model_id');
    }
}
