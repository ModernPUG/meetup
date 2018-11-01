<?php
// Adaptor Design: 8G memory card => plugin(this is adaptor) => PC
require './vendor/autoload.php';

use Acme\Person;
use Acme\Book;

use Acme\Kyobo\Kyobo;
use Acme\Kyobo\KyoboAdapter;
use Acme\Yes24\Yes24;
use Acme\Yes24\Yes24Adapter;


//(new Person)->read(new Book);
(new Person)->read(new Yes24Adapter(new Yes24));
//(new Person)->read(new KyoboAdapter(new Kyobo));



//laravel/vendor/laravel/framework/src/Illuminate/Filesystem/FilesystemAdapter.php