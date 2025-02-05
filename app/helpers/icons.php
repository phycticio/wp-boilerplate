<?php

if(!function_exists('get_page_icon')) {
    function get_page_icon($page_id, $size = '40px') : ?string {
        $icon = get_post_meta($page_id, 'icon', true);
        if($icon) {
            return str_replace('40px', $size, $icon);
        }
        return null;
    }
}