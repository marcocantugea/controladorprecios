<?php

namespace App\Contractors\Repositories;

use App\Contractors\Data\IRepository;

interface IAtributoRepository extends IRepository{

    function searchAtributos(array $searchParams):array;

}