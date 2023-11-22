<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\ICanalesVentaService;
use App\Http\Controllers\Controller;
use App\Mappers\CanalesVentaMapper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class CanalesVentaController extends Controller
{
    private ICanalesVentaService $service;
    private IMapper $mapper;

    public function __construct(ICanalesVentaService $service, CanalesVentaMapper $mapper) {
        $this->service= $service;
        $this->mapper=$mapper;
    }

    public function addCanalVenta(Request $request){
        try {
            $jsonParsed= $this->validateJsonContent($request);
            $dto= $this->mapper->reverse($jsonParsed);
            $publicId=$this->service->addCanalVenta($dto);
            return new Response($this->stdResponse(data:['publicId'=>$publicId]));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function updateCanalVenta(Request $request,string $pid){
        try {
            $jsonParsed= $this->validateJsonContent($request);
            $dto= $this->mapper->reverse($jsonParsed);
            $dto->publicId=$pid;
            $this->service->updateCanalVenta($dto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getCanalVenta($pid){
        try {
            $dto= $this->service->getCanalVenta($pid);
            return new Response($this->stdResponse(data:$dto));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteCanalVenta($pid){
        try {
            $this->service->deleteCanalVenta($pid);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getCanalesVenta(){
        try {
            $dtos=$this->service->getCanalesVenta();
            return new Response($this->stdResponse(data:$dtos));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }
}
