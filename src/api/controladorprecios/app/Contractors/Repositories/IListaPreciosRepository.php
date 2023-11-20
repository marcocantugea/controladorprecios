<?php

namespace App\Contractors\Repositories;

use App\Contractors\Data\IRepository;

interface IListaPreciosRepository extends IRepository{

    function getListasPrecios(bool $activas=true);

}