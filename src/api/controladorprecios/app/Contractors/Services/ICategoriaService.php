<?php

namespace App\Contractors\Services;

use App\DTOs\CategoriaDTO;

interface ICategoriaService{
    
    function addCategoria(CategoriaDTO $dto);
    function updateCategoria(CategoriaDTO $dto);
    function deleteCategoria($id);
    function getCategoria($id,bool $addSubCategorias=false);
    function getCategorias(string $nombre,bool $addSubCategorias=false);
    function addSubCategoria($id,CategoriaDTO $subCategoria);
    function addSubCategorias($id,array $subCategoriasDTO);
    function getSubCategorias($id,bool $loadChilds=false):array;

}