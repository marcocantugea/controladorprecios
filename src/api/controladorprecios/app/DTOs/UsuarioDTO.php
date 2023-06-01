<?php

namespace App\DTOs;

use DateTime;

class UsuarioDTO{

    public ?string $publicId;
    public string $user;
    public string $password;
    public ?string $email;
    public bool $active=false;
    public ?DateTime $created_at;
    public ?DateTime $updated_at;
    public ?DateTime $deleted_at;

    public function __construct(string $user,string $password, string $publicId=null,string $email=null,bool $active=false) {
        $this->user = $user;
        $this->password=$password;
        $this->publicId=$publicId;
        $this->email=$email;
        $this->active=$active;
    }


}