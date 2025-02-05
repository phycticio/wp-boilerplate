<?php
namespace App;

define('APP_THEME_LOCALE', 'app');
define('APP_THEME_URL', get_stylesheet_directory_uri());
define('APP_THEME_DIR', __DIR__);

App::start();

$helpers = glob(APP_PATH . '/helpers/*.php');
if($helpers) {
    foreach($helpers as $helper) {
        if(is_file($helper)) require_once $helper;
    }
}