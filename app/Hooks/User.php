<?php

namespace App\Hooks;

use App\Hooks\User\Api;

class UserHooks {
    public static function init() : void {
        add_action('rest_api_init', Api::register_rest_route(...));
    }
}