<?php

namespace App\Contractors\Services;

use App\DTOs\ProductoDTO;
use App\DTOs\ProveedorProductoDTO;

interface IProductosService {

    function addProduct(ProductoDTO $product);
    function getProducto($id):ProductoDTO;
    function updateProducto(ProductoDTO $producto);
    function getProductos(array $searchParams,int $limit=500,int $offset=0);
    function updateProductoByProperty($id,array $propertyValue);
    function assignProveedor(ProveedorProductoDTO $proveedorProducto);
    function getListaPrecios($pid);
    function getProductoSimple($pid): ProductoDTO;
    function getProductosSimple(array $productosPid) : array;
    function addProductos(array $productosDTOs);
}