<?php

namespace App;

class App {
    public static function start(): void {
        self::loader(APP_PATH.'/Hooks/*.php', 'App\\Hooks\\');
    }

    public static function loader(string $path, string $namespace = 'App\\'): void {
        foreach (glob($path) as $config_file) {
            $class_name = $namespace;
            $class_name .= basename($config_file, '.php');
            if (method_exists($class_name, 'init')) {
                $reflection = new \ReflectionMethod($class_name, 'init');
                if($reflection->isStatic()) {
                    $class_name::init();
                } else {
                    $object = new $class_name();
                    $object->init();
                }
            }
        }
    }
}