<?php

namespace App\Services;

use App\Contractors\Services\IListaPreciosService;
use App\Contractors\Wrappers\IListaPreciosWrapper;
use Exception;

class ListaPreciosService implements IListaPreciosService
{
    private IListaPreciosWrapper $wrapper;
    
    public function __construct(IListaPreciosWrapper $wrapper) {
        $this->wrapper=$wrapper;
    }


    public function getListaPreciosHeader($listaPid)
    {
        try {
            $response=$this->wrapper->getHeaderListaPrecios($listaPid);
            if($response['error']) throw new Exception("error on request $response->message");
            return json_decode(json_encode($response['data']));
        } catch (\Throwable $th) {
            throw $th;
        }    
    }

    public function getListaPreciosProductos($listaPid)
    {
        try {
            $response=$this->wrapper->getDetalleListaPrecios($listaPid);
            if($response['error']) throw new Exception("error on request $response->message");
            return json_decode(json_encode($response['data']));
        } catch (\Throwable $th) {
            throw $th;
        }    
    }
}
