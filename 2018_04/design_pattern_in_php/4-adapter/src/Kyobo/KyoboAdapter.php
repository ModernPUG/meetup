<?php

namespace Acme\Kyobo;

use Acme\BookInterface;
use Acme\Yes24;

class KyoboAdapter implements BookInterface
{

    protected $kindle;

    public function __construct(KyoboInterface $kindle)
    {
        $this->kindle = $kindle;
    }

    public function open()
    {
        $this->kindle->power();
    }

    public function turnPage()
    {
        $this->kindle->nextPage();
    }

}
