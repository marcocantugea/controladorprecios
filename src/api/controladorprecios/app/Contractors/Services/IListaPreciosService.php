<?php

namespace App\Contractors\Services;

interface IListaPreciosService
{
    
    function addListaPrecios($dto);
    function updateListaPrecios($dto);
    function deleteListaPrecios($id);
    function getListaPreciosById($id);
    function getListasPrecios() :array;

}
