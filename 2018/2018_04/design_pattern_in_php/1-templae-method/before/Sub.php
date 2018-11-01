<?php

class TurkeySub
{

    public function make()
    {
        return $this->layBread()
            ->addLettuce()
            ->addTurkey()
            ->addSauces();
    }

    protected function addTurkey()
    {
        var_dump('add Turkey');
        return $this;
    }

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

//(new TurkeySub())->make();






class VegeSub
{

    public function make()
    {
        return $this->layBread()
            ->addLettuce()
            ->addVege()
            ->addSauces();
    }


    protected function addVege()
    {
        var_dump('add vegetable');
        return $this;
    }

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

(new VegeSub())->make();