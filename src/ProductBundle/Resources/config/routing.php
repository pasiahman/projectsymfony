<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('product_homepage', new Route('/product', array(
    '_controller' => 'ProductBundle:Default:index',
)));

return $collection;
