<?php
require "./vendor/autoload.php";
use App\ShapeFactory;


$circleInstance = ShapeFactory::getShapeInstance("CIRCLE");
$triangleInstance = ShapeFactory::getShapeInstance("TRIANGLE");
$squreInstance = ShapeFactory::getShapeInstance("SQUARE");

echo $circleInstance->getType() . " was generated \n";
echo $triangleInstance->getType() . " was generated \n";
echo $squreInstance->getType() . " was generated \n";
