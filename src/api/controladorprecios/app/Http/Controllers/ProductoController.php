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
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getProducto($id){
        try {
            $productoDto=$this->service->getProducto($id);
            return new Response($this->stdResponse(data:$productoDto));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function updateProducto(Request $request,$id){
        try {
            $jsonParsed= json_decode($request->getContent());
            $productoDto= $this->mapper->reverse($jsonParsed);
            $productoDto->publicId=$id;
            $this->service->updateProducto($productoDto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteProducto($id){
        try {
            $this->service->deleteProducto($id);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getProductos(Request $request){
        $searchParams= $request->query();
        try {
            $productosSearchParams=[];
            $limit=500;
            $offset=0;
            foreach ($searchParams as $key => $value) {
                if($key=='offset') {
                    $offset=$value;
                    continue;
                }

                if($key=='limit'){
                    $limit=$value;
                    continue;
                }

                $productosSearchParams+=[$key=>[$value,null]];
            }

            $productosFound=$this->service->getProductos($productosSearchParams,$limit,$offset);

            return new Response($this->stdResponse(data:$productosFound));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    protected function stdResponse($success=true,$error=false,$message="",$data=null){
        return ["success"=>$success,"error"=>$error,"message"=>$message,"data"=>$data];
    }
    
}
