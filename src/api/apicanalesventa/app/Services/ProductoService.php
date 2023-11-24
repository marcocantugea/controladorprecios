<?php

namespace App\Services;

use App\Contractors\Services\IProductoService;
use App\Contractors\Wrappers\IProductoWrapper;
use Exception;

class ProductoService implements IProductoService
{
    private IProductoWrapper $wrapper;

    public function __construct(IProductoWrapper $wrapper) {
        $this->wrapper=$wrapper;
    }

    public function getProductoSimple($pid)
    {
        try {
            $response=$this->wrapper->getProductoSimple($pid);
            if($response['error']) throw new Exception("error on request $response->message");
            return json_decode(json_encode($response['data']));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getProductosSimple(array $productoIds)
    {
        try {
            $response=$this->wrapper->getProductoSimple($productoIds);
            if($response['error']) throw new Exception("error on request $response->message");
            return json_decode(json_encode($response['data']));
        } catch (\Throwable $th) {
            throw $th;
        } 
    }
}
