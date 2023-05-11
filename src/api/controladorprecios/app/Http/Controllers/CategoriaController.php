<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\ICategoriaService;
use App\Mappers\CategoriaMapper;
use App\Services\CategoriaService;
use App\Services\ServicesContainer;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CategoriaController extends BaseController
{
    private ICategoriaService $service;
    private IMapper $mapper;

    public function __construct() {
        $this->service= ServicesContainer::getService(CategoriaService::class);
        $this->mapper= ServicesContainer::getService(CategoriaMapper::class);
    }

    public function addCategoria(Request $request){

        try {
            $jsonParsed= json_decode($request->getContent());
            $dto= $this->mapper->reverse($jsonParsed);
            $this->service->addCategoria($dto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function updateCategoria(Request $request,$id){
        try {
            $jsonParsed= json_decode($request->getContent());
            $dto= $this->mapper->reverse($jsonParsed);
            $dto->publicId=$id;
            $this->service->updateCategoria($dto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getCategoria($id){
        try {
            $dto= $this->service->getCategoria($id);
            return new Response($this->stdResponse(data:$dto));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteCategoria($id){
        try {
            $this->service->deleteCategoria($id);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getCategorias(Request $request){
        $nombre= empty($request->query('nombre')) ? "" : $request->query('nombre');
        try {
            return $this->service->getCategorias($nombre);
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }
}
