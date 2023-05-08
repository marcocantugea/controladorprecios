<?php

namespace App\Http\Controllers;

use App\Mappers\ProductoMapper;
use App\Services\ProductoService;
use App\Services\ServicesContainer;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    private ProductoService $service;
    private ProductoMapper $mapper;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service= ServicesContainer::getService(ProductoService::class);
        $this->mapper= ServicesContainer::getService(ProductoMapper::class);
    }

    public function addProducto(Request $request){

        try {
            $jsonParsed= json_decode($request->getContent());
            $productoDto= $this->mapper->reverse($jsonParsed);
            $this->service->addProduct($productoDto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    public function getProducto($id){
        try {
            $productoDto=$this->service->getProducto($id);
            return new Response($this->stdResponse(data:$productoDto));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    protected function stdResponse($success=true,$error=false,$message="",$data=null){
        return ["success"=>$success,"error"=>$error,"message"=>$message,"data"=>$data];
    }
    
}
