<?php

namespace Acme\Kyobo;

class Kyobo implements KyoboInterface
{

    public function power()
    {
        var_dump('turn kybo power on');
    }

    public function nextPage()
    {
        var_dump('press next button on kybo');
    }
}
