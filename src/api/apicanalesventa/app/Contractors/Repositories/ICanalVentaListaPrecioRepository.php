<?php

namespace App\Contractors\Repositories;

use App\Contractors\Repositories\IRepository;

interface ICanalVentaListaPrecioRepository extends IRepository{

    function getListasPrecioPorCanalVenta($pid);
    function getCanalVentaPorListaPrecio($listaPid);
}