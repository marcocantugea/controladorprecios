<?php

namespace App\Contractors\Services;

interface IListaPreciosProductoService {

    function addListaPrecioProducto($dto);
    function updateListaPrecioProducto($dto);
    function deleteListaPrecioProducto($pid);
    function getListaPrecioProductoById($pid);
    function getProductosPorListaPrecios($listaPId);
    function addProductosAListaPrecios(array $dtos);
    function getProductoPrecio($listaPid,$productoPid);
    function getProductoPrecios($productoId);
}