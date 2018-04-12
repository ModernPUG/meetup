<?php

namespace App;

class Vegetable extends Sub
{

    public function addPrimaryFood(): Sub
    {
        var_dump('add vegetable');

        return $this;
    }
}
