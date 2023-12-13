<?php

namespace App\DTOs;

use JsonSerializable;

class RolUsuarioDTO  implements JsonSerializable
{
    public string $publicId;
    public string $usuarioPid;
    public string $rolPid;
    public RolDTO $rol;

    public function jsonSerialize(): mixed
    {
        return array_filter((array) $this, function ($var) {
            return !is_null($var);
        });
    }

}
