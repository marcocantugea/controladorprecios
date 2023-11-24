<?php

namespace App\Wrappers;

use App\Contractors\Wrappers\IListaPreciosWrapper;
use Exception;
use Illuminate\Support\Facades\Http;

class ListaPreciosWrapper implements IListaPreciosWrapper
{
    private string $token;

    public function __construct(string $token="") {
        $this->token= (!empty($token)) ? $token : $_SESSION['token'];
    }

    public function getHeaderListaPrecios($listaPid)
    {
        $this->validateToken();
        $apiPath= $this->getAPIPath();
        if(empty($apiPath)) throw new \Exception("No Api Path found", 1);
        
        $response=  Http::withHeaders([
            'Authorization'=> 'Basic '.$this->token
        ])->get( $apiPath."listaprecios/$listaPid")->throw()->json();
        
        return $response;   
    }

    public function getDetalleListaPrecios($listaPid)
    {
        $this->validateToken();
        $apiPath= $this->getAPIPath();
        if(empty($apiPath)) throw new \Exception("No Api Path found", 1);
        
        $response= Http::withHeaders([
            'Authorization'=> 'Basic '.$this->token
        ])->get( $apiPath."listaprecios/$listaPid/productos")->throw()->json();
        
        return $response;   
    }

    private function getAPIPath(){
        $apiHost= (!empty($_ENV['PRODUCTOS_API_HOST'])) ? $_ENV['PRODUCTOS_API_HOST'] : getenv('PRODUCTOS_API_HOST');
        $apiVersion=(!empty($_ENV['PRODUCTOS_API_VERSION'])) ? $_ENV['PRODUCTOS_API_VERSION'] : getenv('PRODUCTOS_API_VERSION');

        return $apiHost.$apiVersion;
    }

    public function validateToken(){
        if(empty($this->token)) throw new Exception('invalid user for microservice');
    }
}
