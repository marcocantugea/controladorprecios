<?php

namespace App\DTOs;

use JsonSerializable;

final class CanalVentaDTO implements JsonSerializable
{
   public ?string $publicId;
   public string $nombre;
   public string $codigo;
   public bool $activo;

   public function jsonSerialize() :mixed
   {
       return array_filter((array) $this, function ($var) {
           return !is_null($var);
       });
   }
}
