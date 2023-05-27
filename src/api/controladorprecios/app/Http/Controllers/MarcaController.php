<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\IMarcasService;
use App\Mappers\MarcaMapper;
use App\Services\MarcasService;
use App\Services\ServicesContainer;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class MarcaController extends BaseController{

    private IMarcasService $service;
    private IMapper $mapper;

    public function __construct() {
        $this->service= ServicesContainer::getService(MarcasService::class);
        $this->mapper= ServicesContainer::getService(MarcaMapper::class);
    }

    public function addMarca(Request $request){
        try {
            $jsonParsed= json_decode($request->getContent());
            if($jsonParsed==null) return new Response($this->stdResponse(false,true,"invalid request"),400);
            $marcaDto= $this->mapper->reverse($jsonParsed);
            if(empty($marcaDto)) return new Response($this->stdResponse(false,true,"invalid request"),400);
            $this->service->addMarca($marcaDto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    public function updateMarca(Request $request, $id){
        try {
            $jsonParsed= json_decode($request->getContent());
            if($jsonParsed==null) return new Response($this->stdResponse(false,true,"invalid request"),400);
            $marcaDto= $this->mapper->reverse($jsonParsed);
            if(empty($marcaDto)) return new Response($this->stdResponse(false,true,"invalid request"),400);
            $marcaDto->publicId=$id;
            $this->service->updateMarca($marcaDto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    public function deleteMarca($id){
        try {
            if(empty($id)) return new Response($this->stdResponse(false,true,"invalid request"),400);
            $this->service->deleteMarca($id);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    public function getMarca($id){
        try {
            if(empty($id)) return new Response($this->stdResponse(false,true,"invalid request"),400);
            $dto=$this->service->getMarca($id);
            return new Response($this->stdResponse(data:$dto));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    public function getMarcas(Request $request){
        try {
            
            $searchParams= $request->query();
            $productosSearchParams=[];
            foreach ($searchParams as $key => $value) {
                $productosSearchParams+=[$key=>[$value,null]];
            }
            $items= $this->service->getMarcas($productosSearchParams);
            return new Response($this->stdResponse(data:$items));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }
}