<?php

namespace App\Contractors\Repositories;

use App\Contractors\Data\IRepository;
use App\DTOs\CategoriaDTO;

interface IProductosRepository extends IRepository{

    function getProductos(array $searchParams,int $limit=500,int $offset=0);
    function updateProductoByProperty(string $id,array $fieldValue);
    function assignCategoryToProduct(string $id,array $categoriaDto);
    function getCategoriasOfProducto($id);
    function assignAtributoToProduct(string $id, array $atributosDto);
    function getAtributosOfProducto($id);
    function addServalProductos(array $productosModels);
}