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
}
