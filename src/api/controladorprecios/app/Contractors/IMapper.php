<?php

namespace App\Contractors;

interface IMapper {
    
    function map($DTO);
    function reverse($model);
}