<?php

namespace App\Contractors\Wrappers;

interface IProductoWrapper{

    function getProductoSimple($pid);
    function getProductosSimple(array $productodId);
}
