<?php 

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\IListaPreciosProductoService;
use App\Contractors\Services\IListaPreciosService;
use App\Enums\AccionsEnums;
use App\Mappers\ListaPreciosMapper;
use App\Mappers\ListaPreciosProductoMapper;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

final class ListaPreciosController extends BaseController
{
    private IListaPreciosService $service;
    private ListaPreciosMapper $listaPrecioMapper;
    private ListaPreciosProductoMapper $listaPrecioProductoMapper;
    private IListaPreciosProductoService $listaPreciosProductoService;
    
    public function __construct(ListaPreciosMapper $mapper, 
        IListaPreciosService $service,
        ListaPreciosProductoMapper $listaPrecioProductoMapper,
        IListaPreciosProductoService $listaPreciosProductoService
    ) {
        $this->listaPrecioMapper=$mapper;
        $this->service= $service;
        $this->listaPrecioProductoMapper= $listaPrecioProductoMapper;
        $this->listaPreciosProductoService= $listaPreciosProductoService;
    }

    public function addListaPrecio(Request $request){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_LISTAPRECIOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $jsonParsed= $this->validateJsonContent($request);
            $dto= $this->listaPrecioMapper->reverse($jsonParsed);
            $this->service->addListaPrecios($dto);
            return new Response($this->stdResponse());

        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function updateListaPrecio(Request $request,$pid){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::UPDATE_PERMIT,AccionsEnums::UPDATE_LISTAPRECIOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $jsonParsed= $this->validateJsonContent($request);
            $dto=$this->listaPrecioMapper->reverse($jsonParsed);
            $dto->publicId=$pid;
            $this->service->updateListaPrecios($dto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteListaPrecios($pid){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::DELETE_PERMIT,AccionsEnums::DELETE_LISTAPRECIOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $this->service->deleteListaPrecios($pid);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getListaPrecios($pid){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_LISTAPRECIOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $data= $this->service->getListaPreciosById($pid);
            return new Response($this->stdResponse(data:$data));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getListasPrecios(){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_LISTAPRECIOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $data= $this->service->getListasPrecios();
            return new Response($this->stdResponse(data:$data));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function addProductoListaPrecios(Request $request){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_LISTAPRECIOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $jsonParsed= $this->validateJsonContent($request);
            $dto= $this->listaPrecioProductoMapper->reverse($jsonParsed);
            $publicId=$this->listaPreciosProductoService->addListaPrecioProducto($dto);
            return new Response($this->stdResponse(data:['publicId'=>$publicId]));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function addProductosListaPrecios(Request $request){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_LISTAPRECIOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $jsonParsed= $this->validateJsonContent($request);
            $dtos=[];
            foreach ($jsonParsed as $item) {
                $dto=$this->listaPrecioProductoMapper->reverse($item);
                if(empty($dto)) continue;
                array_push($dtos,$dto);
            }
            $data= $this->listaPreciosProductoService->addProductosAListaPrecios($dtos);
             return new Response($this->stdResponse(data:$data));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getProductosPorListaPrecio($listaPId){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_LISTAPRECIOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $data = $this->listaPreciosProductoService->getProductosPorListaPrecios($listaPId);
            return new Response($this->stdResponse(data:$data));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getProductoPrecio($pid,$productoPid){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_LISTAPRECIOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $data= $this->listaPreciosProductoService->getProductoPrecio($pid,$productoPid);
            return new Response($this->stdResponse(data:$data));

        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getProductoPrecios($productoPId){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_LISTAPRECIOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $data= $this->listaPreciosProductoService->getProductoPrecios($productoPId);
            return new Response($this->stdResponse(data:$data));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getListaPreciosPorProducto($productoPId){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_LISTAPRECIOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $data=$this->listaPreciosProductoService->getListaPreciosPorProducto($productoPId);
            return new Response($this->stdResponse(data:$data));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }
}
