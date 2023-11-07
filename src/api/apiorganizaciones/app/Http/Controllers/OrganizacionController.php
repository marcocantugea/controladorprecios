<?php

namespace App\Http\Controllers;

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

            $jsonParsed= json_decode($request->getContent());
            if(!isset($jsonParsed->nombre) || !isset($jsonParsed->descripcion)) 
                return new Response($this->stdResponse(false,true,"invalid request"),400);

            $dto= $this->mapper->reverse($jsonParsed);

            $publicId=$this->service->addOrganizacion($dto);
            return new Response($this->stdResponse(data:['publicId'=>$publicId]));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    public function getOrganizacion($publicId){
        try {
            return new Response($this->stdResponse(data:$this->service->getOrganizacion($publicId)));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    public function deleteOrganizacion($publicId){
        try {
            $this->service->deleteOrganizacion($publicId);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }
}
