<?php

namespace App\Contractors\Services;

interface ICanalVentaListaPrecioService{

    function addCanalVentaListaPrecio($dto);
    function deleteCanalVentaListaPrecio($pid);
    function getListaPreciosPorCanal($pid);
    function getCanalesPorListaPrecios($listaPid);
    function getListaPrecioPorCanal($pid,$listaPid);
}