<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

    protected $table = 't_article';
    protected $primaryKey = 'idx';
    const CREATED_AT = 'reg_date';
    const UPDATED_AT = 'mod_date';
    protected $fillable = ['title', 'body'];


}