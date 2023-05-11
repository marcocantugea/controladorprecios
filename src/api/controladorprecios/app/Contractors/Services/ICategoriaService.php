<?php

namespace App\Contractors\Services;

use App\DTOs\CategoriaDTO;

interface ICategoriaService{
    
    function addCategoria(CategoriaDTO $dto);
    function updateCategoria(CategoriaDTO $dto);
    function deleteCategoria($id);
    function getCategoria($id);
    function getCategorias(array $searchParameters);

}