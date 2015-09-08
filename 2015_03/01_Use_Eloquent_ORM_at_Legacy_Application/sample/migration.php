<?php
use Illuminate\Database\Capsule\Manager;

include_once "vendor/autoload.php";

$capsule = new Manager();

if (!$capsule::schema()->hasTable('users')) {
    $capsule::schema()->create('users', function ($table) {
        $table->increments('id');
        $table->string('email')->unique();
        $table->timestamps();
    });
}

if (!$capsule::schema()->hasTable('t_article')) {
    $capsule::schema()->create('t_article', function ($table) {
        $table->increments('id');
        $table->string('title');
        $table->string('body');
        $table->integer('user_id');
        $table->dateTime('reg_date');
        $table->dateTime('mod_date');
        $table->timestamps();
    });
}
