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

}
