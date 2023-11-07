<?php

namespace App\Repositories;

use App\Models\Organizacion;
use DateTime;
use Illuminate\Support\Facades\DB;

class OrganizacionRepository 
{
    public const TABLE_ORG ='organizacion';

    public function addOrganizacion(Organizacion $organizacion){
        try {
            $id=DB::table($this::TABLE_ORG)->insertGetId([
                'publicId'=>uniqid(),
                'nombre'=>$organizacion->nombre,
                'descripcion'=>$organizacion->descripcion,
                'codigo'=>$organizacion->codigo,
                'created_at'=>new DateTime()
            ]);
            $organizacionPublicId= DB::table(self::TABLE_ORG)->where('id',$id)->first()->publicId;
            return $organizacionPublicId;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getOrganizacion(string $publicId){
        return DB::table($this::TABLE_ORG)->where('publicId',$publicId)->whereNull('fecha_eliminado')
        ->select([
            'publicId',
            'nombre',
            'descripcion',
            'codigo',
            'created_at',
            'updated_at',
            'fecha_eliminado'
        ])->first();
    }

    public function deleteOrganizacion(string $publicId, bool $activa=true){
        DB::table($this::TABLE_ORG)->where('publicId',$publicId)->whereNull('fecha_eliminado')
        ->update([
            'fecha_eliminado'=> new DateTime()
        ]);
    }
}
