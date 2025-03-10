<?php

namespace App\Hooks;

class User
{
    public function init(): void
    {
        add_action('rest_api_init', ['App\\Hooks\\User\\Api', 'register_rest_route']);
    }
}
