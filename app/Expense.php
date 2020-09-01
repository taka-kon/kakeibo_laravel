<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $guarded = array('id');
    public static $rules= array(
        'user_id'=>'required',
        'day'=>'required',
        'genre'=>'required',
        'minus'=>'required',
    );

    public function users(){
        return $this->belongsTo('App\Users','user_id');
    }

    public function getId(){
        return $this->id;
    }

    public function getUserName(){
        return $this->users['name'];
    }

    public function getDay(){
        return $this->day;
    }
    public function getGenre(){
        return $this->genre;
    }
    public function getMinus(){
        return $this->minus;
    }
    public function getCreated(){
        return $this->created_at;
    }
}
