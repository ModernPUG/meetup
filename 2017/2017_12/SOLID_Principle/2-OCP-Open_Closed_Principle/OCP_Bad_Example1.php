<?php


namespace App\SOLID\OCP;


class Square
{

    public $width;
    public $height;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }
}


class Circle
{

    public $radius;

    public function __construct($radius)
    {
        $this->radius = $radius;
    }
}


class AreaCalculator
{

    public function calculate($shapes)
    {
        $area = [];

        foreach ($shapes as $shape) {
            if (is_a($shape, 'Square')) {

                $area[] = $shape->width * $shape->height;

            } elseif (is_a($shape, 'Circle')) {

                $area[] = $shape->radius * $shape->radius * pi();

            } elseif (is_a($shape, 'Triangle')) {

            }
        }

        return array_sum($area);
    }
}
