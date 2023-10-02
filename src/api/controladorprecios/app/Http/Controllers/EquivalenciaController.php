<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\IEquivalenciasService;
use App\DTOs\EquivalenciaDTO;
use App\Mappers\EquivalenciaMapper;
use App\Services\EquivalenciasService;
use App\Services\ServicesContainer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EquivalenciaController extends BaseController
{
    private IEquivalenciasService $service;
    private IMapper $mapper;

    public function __construct() {
        $this->service=ServicesContainer::getService(EquivalenciasService::class);
        $this->mapper=ServicesContainer::getService(EquivalenciaMapper::class);
    }

    public function addEquivalencia(Request $request){
        try {
            $jsonParsed= $this->validateJsonContent($request);
            if($jsonParsed instanceof Response) return $jsonParsed;
            $dto = $this->mapper->reverse($jsonParsed);
            $this->service->addEquivalencia($dto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    public function addEquivalencias(Request $request,$id){
        try {
            $jsonParsed= $this->validateJsonContent($request);
            if($jsonParsed instanceof Response) return $jsonParsed;
            if(!is_array($jsonParsed)) new Response($this->stdResponse(false,true,"invalid content"),400);
            
            $dtos=array_map(function($item) use ($id){
                return new EquivalenciaDTO($id,$item->productoPublicIdEqu);
            },$jsonParsed);
            $this->service->addEquivalencias($dtos);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    public function deleteEquivalencia($publicId){
        try {
            $this->service->deleteEquivalencia($publicId);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }
}
