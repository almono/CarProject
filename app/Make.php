<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Make extends Model
{
    protected $table = 'makes';

    public function models()
    {
        return $this->hasMany('App\CarModel');
    }
}
