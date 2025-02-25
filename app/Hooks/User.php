<?php

namespace App\Hooks;

use App\Hooks\User\Api;

class User {
    public function init() : void {
        add_action('rest_api_init', Api::register_rest_route(...));
    }
}