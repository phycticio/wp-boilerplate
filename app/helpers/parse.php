<?php

if(!function_exists('parse_env_text')) {
    function parse_env_text($env_text) : array {
        $variables = [];

        $lines = explode("\n", $env_text);

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || str_starts_with($line, '#')) {
                continue;
            }

            if (preg_match("/^([A-Z_]+)='([^']*)'/", $line, $matches)) {
                $key = strtolower($matches[1]);
                $value = $matches[2];
                $variables[$key] = $value;
            }
        }

        return $variables;
    }
}