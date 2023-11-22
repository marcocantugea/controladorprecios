<?php

namespace App\Contractors\Services;

interface ICanalesVentaService{

    function addCanalVenta($dto);
    function updateCanalVenta($dto);
    function getCanalVenta($pid);
    function deleteCanalVenta($pid);
    function getCanalesVenta();
}