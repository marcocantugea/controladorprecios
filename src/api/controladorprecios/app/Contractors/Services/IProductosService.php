<?php

namespace App\Contractors\Services;

use App\DTOs\ProductoDTO;

interface IProductosService {

    function addProduct(ProductoDTO $product);
    function getProducto($id):ProductoDTO;
    function updateProducto(ProductoDTO $producto);
}