<?php

namespace Acme;

use Acme\BookInterface;

class Book implements BookInterface
{

    public function open()
    {
        var_dump('open the paper book');
    }

    public function turnPage()
    {
        var_dump('turning the page of the paper book');
    }
}
