<?php 

namespace App\Contractors\Repositories;

interface IAccionesRepository{

    function getAccionById($pid);
    function getAcciones();

}