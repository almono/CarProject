<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table = 'car_models';

    public function submodels()
    {
        return $this->belongsToMany('App\CarSubModel','models_submodels','model_id','submodel_id');
    }
}
