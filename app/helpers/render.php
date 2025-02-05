<?php

if(!function_exists('app_render')) {
    function app_render($block, $content, $is_preview) : void {
        \App\Setup\Blocks::render($block, $content, $is_preview);
    }
}