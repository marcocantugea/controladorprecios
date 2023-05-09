<?php

namespace App\Contractors\Repositories;

use App\Contractors\Data\IRepository;

interface IProductosRepository extends IRepository{

    function getProductos(array $searchParams,int $limit=500,int $offset=0);
    function updateProductoByProperty(string $id,array $fieldValue);
}