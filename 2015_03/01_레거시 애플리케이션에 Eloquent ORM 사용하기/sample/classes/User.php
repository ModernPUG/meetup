<?php namespace App;
use Illuminate\Database\Eloquent\Model;

class User extends Model {
    protected $fillable = ['email'];

    function article()
    {
        return $this->hasMany('Article', 'user_id');
    }
} 