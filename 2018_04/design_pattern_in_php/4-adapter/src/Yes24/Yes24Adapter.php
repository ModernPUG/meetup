<?php

namespace Acme\Yes24;

use Acme\BookInterface;

class Yes24Adapter implements BookInterface
{

    protected $kindle;

    public function __construct(Yes24Interface $kindle)
    {
        $this->kindle = $kindle;
    }

    public function open()
    {
        $this->kindle->turnOn();
    }

    public function turnPage()
    {
        $this->kindle->nextButton();
    }

}
