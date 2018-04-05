<?php

namespace Acme\Yes24;

class Yes24 implements Yes24Interface
{

    public function turnOn()
    {
        var_dump('turn the yes24 on');
    }

    public function nextButton()
    {
        var_dump('press next page on the yes24');
    }
}
