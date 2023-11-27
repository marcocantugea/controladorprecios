<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\IAccionesService;
use App\Enums\AccionsEnums;
use App\Mappers\AccionMapper;
use Illuminate\Http\Response;

final class AccionesController extends Controller
{
    private IAccionesService $service;

    public function __construct(IAccionesService $service) {
        $this->service =$service;
    }

    public function getAccion($pid){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_ROL_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $dto=$this->service->getAccionById($pid);
            return new Response($this->stdResponse(data:$dto));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getAcciones(){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_ROL_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $dtos=$this->service->getAcciones();
            return new Response($this->stdResponse(data:$dtos));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }
}
