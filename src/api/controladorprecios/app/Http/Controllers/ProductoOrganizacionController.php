<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\IProductoOrganizacion;
use App\Enums\AccionsEnums;
use App\Mappers\ProductoOrganizacionMapper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class ProductoOrganizacionController extends BaseController
{
    private IProductoOrganizacion $productoOrganizacionService;
    private IMapper $mapper;

    public function __construct(IProductoOrganizacion $service,ProductoOrganizacionMapper $mapper) {
        $this->productoOrganizacionService=$service;
        $this->mapper=$mapper;
    }

    public function addOrganzacion($productoId,Request $request){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_PRODUCTO_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $jsonParsed= json_decode($request->getContent());
            $dto= $this->mapper->reverse($jsonParsed);
            $publicId=$this->productoOrganizacionService->addOrganizacion($productoId,$dto);
            return new Response($this->stdResponse(data:['publicId'=>$publicId]));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteOrganizacion($pid){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::DELETE_PERMIT,AccionsEnums::DELETE_PRODUCTOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $this->productoOrganizacionService->deleteOrganizacion($pid);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getOrganizaciones($productoId){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_PRODUCTOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $data=$this->productoOrganizacionService->getOrganizaciones($productoId);
            return new Response($this->stdResponse(data:$data));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }
}
