<?php

namespace App\Contractors\Services;

interface IListaPreciosService {


    function getListaPreciosHeader($listaPid);
    function getListaPreciosProductos($listaPid);

}