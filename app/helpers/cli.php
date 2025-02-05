<?php

if(!function_exists('is_cli')) {
    function is_cli() : bool {
        return (php_sapi_name() === 'cli');
    }
}