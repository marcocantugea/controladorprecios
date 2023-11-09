<?php

namespace App\Contractors\Wrappers;

use stdClass;

interface IOrganizacionWrapper {

    function getOrganizacion(string $pid) : stdClass;

}