<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\IEquivalenciasService;
use App\DTOs\EquivalenciaDTO;
use App\Enums\AccionsEnums;
use App\Mappers\EquivalenciaMapper;
use App\Services\EquivalenciasService;
use App\Services\ServicesContainer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EquivalenciaController extends BaseController
{
    private IEquivalenciasService $service;
    private IMapper $mapper;

    public function __construct(IEquivalenciasService $equivalenciaService,EquivalenciaMapper $mapper ) {
        $this->service=$equivalenciaService;
        $this->mapper=$mapper;
    }

    public function addEquivalencia(Request $request){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_EQUIVALENCIA_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
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
            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_EQUIVALENCIA_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
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
            if(!$this->HasAccionsPermit([AccionsEnums::DELETE_PERMIT,AccionsEnums::DELETE_EQUIVALENCIA_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $this->service->deleteEquivalencia($publicId);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }
}
