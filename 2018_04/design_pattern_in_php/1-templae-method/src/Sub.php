<?php

namespace App;

abstract class Sub
{

    public function make()
    {
        return $this->layBread()
            ->addLettuce()
            ->addPrimaryFood()
            ->addSauces();
    }

    abstract protected function addPrimaryFood(): Sub;

    protected function addSauces()
    {
        var_dump("add sauces");
        return $this;
    }

    protected function addLettuce()
    {
        var_dump("add some lettuce");
        return $this;
    }

    protected function layBread()
    {
        var_dump("laying down some bread");
        return $this;
    }

}
