<?php

namespace App\Contractors\Repositories;

use App\Contractors\Data\IRepository;

interface IMarcaRepository extends IRepository{

    function getMarcas(array $serachParams) :array;

}
