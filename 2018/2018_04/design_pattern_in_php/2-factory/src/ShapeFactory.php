<?php
/**
 * Created by PhpStorm.
 * User: ost
 * Date: 2018. 4. 4.
 * Time: PM 5:54
 */

namespace App;


class ShapeFactory
{
    /**
     * @var ShapeInterface[]
     */
    static $shapeClasses =
        [
            Circle::class, Square::class, Triangle::class
        ];

    static public function getShapeInstance($shapeType): ShapeInterface
    {
        foreach (static::$shapeClasses as $shapeClass) {
            if ($shapeType == $shapeClass::getType()) {
                return (new $shapeClass)->getInstance();
            }
        }
    }
}