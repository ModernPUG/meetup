<?php

namespace App;
/**
 * Created by PhpStorm.
 * User: ost
 * Date: 2018. 4. 4.
 * Time: PM 5:50
 */
interface ShapeInterface
{
    static public function getType();

    public function getInstance(): ?ShapeInterface;
}