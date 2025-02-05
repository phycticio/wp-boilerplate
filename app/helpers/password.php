<?php

if (!function_exists('app_is_secure_password')) {
    function app_is_secure_password(string $password): bool {
        $pattern = '/^(?=.*[A-Z])(?=.*[\W])(?=.*[a-zA-Z0-9]).{8,}$/';
        return preg_match($pattern, $password) === 1;
    }
}