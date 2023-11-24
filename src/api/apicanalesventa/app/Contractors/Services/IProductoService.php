<?php

namespace App\Contractors\Services;

interface IProductoService
{
    function getProductoSimple($pid);
    function getProductosSimple(array $productoIds);
}
