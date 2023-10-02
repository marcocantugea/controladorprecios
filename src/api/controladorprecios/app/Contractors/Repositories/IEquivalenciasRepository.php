<?php

namespace App\Contractors\Repositories;

use App\Contractors\Data\IRepository;

interface IEquivalenciasRepository extends IRepository {

    function existProductEquivalencia(int $productoId,int $productoIdEqu);
    function getEquivalenciasByProducto(string $productoId);

}