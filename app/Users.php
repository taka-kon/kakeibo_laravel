<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $guarded=array('id');

    public function getName(){
        return $this->name;
    }

    public function expenses(){
        return $this->hasMany('App\Expense');
    }
}
