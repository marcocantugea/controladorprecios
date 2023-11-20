<?php

namespace App\Contractors\Repositories;

use App\Contractors\Data\IRepository;

interface IListaPreciosProductoRepository extends IRepository{

    function existProductOnList($productoPId,$listPid) :bool;
    function getProductosPorListaPrecios($listPid);
    function addProductosAListaPrecios(array $models);
    function getProductoPrecio($listaPid,$productoPid);
    function getProductoPrecios($productoId);
}