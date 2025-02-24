<?php
namespace App\Helpers;

class Cli {
    public static function is_cli() : bool {
        return (php_sapi_name() === 'cli');
    }
}
