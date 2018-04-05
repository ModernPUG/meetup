<?php

namespace App;
/**
 * Created by PhpStorm.
 * User: ost
 * Date: 2018. 4. 4.
 * Time: PM 5:51
 */
class Circle implements ShapeInterface
{
    static public function getType()
    {
        return "CIRCLE";
    }

    public function getInstance(): ShapeInterface
    {
        return $this;
    }
}