<?php

namespace App\Http\Controllers;

use App\Contractors\Services\IProductosService;
use App\Enums\AccionsEnums;
use App\Mappers\ProductoMapper;
use App\Services\ProductoService;
use App\Services\ServicesContainer;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ProductoController extends BaseController
{
    private ProductoService $service;
    private ProductoMapper $mapper;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(IProductosService $productoService,ProductoMapper $mapper)
    {
        $this->service= $productoService;
        $this->mapper= $mapper;
    }

    public function addProducto(Request $request){

        try {

            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_PRODUCTO_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

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

            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_PRODUCTOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

            $productoDto=$this->service->getProducto($id);
            return new Response($this->stdResponse(data:$productoDto));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function updateProducto(Request $request,$id){
        try {

            if(!$this->HasAccionsPermit([AccionsEnums::UPDATE_PERMIT,AccionsEnums::UPDATE_PRODUCTOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

            $jsonParsed= json_decode($request->getContent());
            $productoDto= $this->mapper->reverse($jsonParsed);
            $productoDto->publicId=$id;
            $this->service->updateProducto($productoDto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function updateProductoByProperty(Request $request,$id){
        try {

            if(!$this->HasAccionsPermit([AccionsEnums::UPDATE_PERMIT,AccionsEnums::UPDATE_PRODUCTOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

            $jsonParsed= json_decode($request->getContent(),true);
            $this->service->updateProductoByProperty($id,$jsonParsed);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteProducto($id){
        try {

            if(!$this->HasAccionsPermit([AccionsEnums::DELETE_PERMIT,AccionsEnums::DELETE_PRODUCTOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

            $this->service->deleteProducto($id);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getProductos(Request $request){
        $searchParams= $request->query();
        try {

            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_PRODUCTOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

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
    
    public function getProductoSimple($pid){
        try {

            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_PRODUCTOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

            $producto=$this->service->getProductoSimple($pid);
            return new Response($this->stdResponse(data:$producto));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getProductosSimple(Request $request){
        try {

            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_PRODUCTOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

            $searchParams= $request->query();
            $jsonParsed=json_encode($searchParams);
            $items=json_decode($jsonParsed);
            if(!isset($items->productos)) return new Response($this->stdResponse(false,true,'missing productos parameter'),400);
            $productosIds= explode(',',$items->productos);
            $data= $this->service->getProductosSimple($productosIds);
            return new Response($this->stdResponse(data:$data));
        return new Response($this->stdResponse(data:$productosIds));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function addSeveralProductos(Request $request){
        try {

            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_PRODUCTO_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

            $jsonParsed= $this->validateJsonContent($request);
            if(! is_array($jsonParsed)) return new Response($this->stdResponse(false,true,"invalid payload"),400);

            $dtos=[];
            array_walk($jsonParsed,function($item) use (&$dtos){
                $productoDto= $this->mapper->reverse($item);
                if(!empty($productoDto)) array_push($dtos,$productoDto);
            });
            
            $publicIds=[];
            if(count($dtos)>0) $publicIds= $this->service->addProductos($dtos);

            return new Response($this->stdResponse(data:$publicIds));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }
}
