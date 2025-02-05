<?php

if(!function_exists('app_render')) {
    function app_render($block, $content, $is_preview) : void {
        \App\Hooks\Blocks::render($block, $content, $is_preview);
    }
}