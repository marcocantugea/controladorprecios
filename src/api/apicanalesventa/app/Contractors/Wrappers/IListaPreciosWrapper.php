<?php

namespace App\Contractors\Wrappers;

interface IListaPreciosWrapper{

    function getHeaderListaPrecios($listaPid);
    function getDetalleListaPrecios($listaPid);

}