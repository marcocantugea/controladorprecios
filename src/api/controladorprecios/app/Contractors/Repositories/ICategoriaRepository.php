<?php

namespace App\Contractors\Repositories;
use App\Contractors\Data\IRepository;
use App\Contractors\Models\Categoria;

interface ICategoriaRepository extends IRepository{

    function searchCategory(string $nombre, bool $esSubcategoria=false);
    function addSubCategoria($id,Categoria $model);
    function addSubCategorias($id, array $CategoriasModel);
    function getSubCategoria($id);
    function hasSubCategorias($id) : bool;
}