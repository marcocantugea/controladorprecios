<?php

namespace App\Contractors\Wrappers;

interface IAuthWrapper {
    
    /**
     * Authenticate user
     * @param string $user
     * @param string $password
     * @return array|mixed|null
     */
    function AuthenticatedUser($user,$password);
}