<?php

namespace App;

class TurkeySub extends Sub
{

    public function addPrimaryFood(): Sub
    {
        var_dump("add turkey");
        return $this;
    }
}
