<?php

namespace App\Http\Controllers;

use App\Enums\AccionsEnums;
use App\Services\OrganizacionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Mappers\OrganizacionMapper;

class OrganizacionController extends Controller
{
    private OrganizacionService $service;
    private OrganizacionMapper $mapper;

    public function __construct( OrganizacionService $service,OrganizacionMapper $mapper) {
        $this->service=$service;
        $this->mapper=$mapper;
    }

    public function addOrganizacion(Request $request){

        try {
            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_ORGANIZACION_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $jsonParsed= json_decode($request->getContent());
            if(!isset($jsonParsed->nombre) || !isset($jsonParsed->descripcion)) 
                return new Response($this->stdResponse(false,true,"invalid request"),400);

            $dto= $this->mapper->reverse($jsonParsed);

            $publicId=$this->service->addOrganizacion($dto);
            return new Response($this->stdResponse(data:['publicId'=>$publicId]));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getOrganizacion($publicId){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_ORGANIZACION_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            return new Response($this->stdResponse(data:$this->service->getOrganizacion($publicId)));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteOrganizacion($publicId){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::DELETE_PERMIT,AccionsEnums::DELETE_ORGANIZACION_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $this->service->deleteOrganizacion($publicId);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getOrganizaciones(){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_ORGANIZACION_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            return new Response($this->stdResponse(data:$this->service->getOrganizaciones()));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }
}
