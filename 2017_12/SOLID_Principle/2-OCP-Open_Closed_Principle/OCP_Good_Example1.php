<?php

namespace App\SOLID\OCP;

interface ShapeInterface
{

    public function area();
}

class Square implements ShapeInterface
{

    public $width;
    public $height;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function area()
    {
        return $this->width * $this->height;
    }
}


class Circle implements ShapeInterface
{

    public $radius;

    public function __construct($radius)
    {
        $this->radius = $radius;
    }

    public function area()
    {
        return $this->radius * $this->radius * pi();
    }

}

class Triangle implements ShapeInterface
{


    public function area()
    {
        // TODO: Implement area() method.
    }
}


class AreaCalculator
{

    /**
     * @param ShapeInterface[] $shapes
     * @return float|int
     */
    public function calculate($shapes)
    {
        $area = [];

        /** @var ShapeInterface $shape */
        foreach ($shapes as $shape) {
            if ($shape instanceof ShapeInterface) {

            }
            $area[] = $shape->area();
        }

        return array_sum($area);
    }
}