<?php

namespace Acme;

use Acme\BookInterface;

class Person
{

    public function read(BookInterface $book)
    {
        $book->open();
        $book->turnPage();
    }
}



