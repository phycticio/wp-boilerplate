<?php

namespace App\Hooks;

use Timber\Timber;

class Blocks {
	public static function init() : void {
        add_action('init', self::register_block_types(...));
	}

    public static function register_block_types(): void
    {
        $block_types = glob(APP_THEME_DIR . '/dist/blocks/*');
        if (count($block_types) > 0) {
            foreach ($block_types as $block) {
                if (is_dir($block)) {
                    $block_data = register_block_type($block);

                    add_filter(
                        'allowed_block_types_all',
                        function ($allowed_blocks) use ($block_data) {
                            if (!is_array($allowed_blocks)) return $allowed_blocks;
                            $allowed_blocks[] = $block_data->name;
                            return $allowed_blocks;
                        }, 99, 2);
                }
            }
        }
    }

    public static function render( $block, $content = '', $is_preview = false ) : void {
        $block_name = sanitize_title_with_dashes(str_replace('app/', '', $block['name']));
        $block_template = $block_name . '.twig';

        $context = Timber::context([
            'block' => $block,
            'is_preview' => $is_preview,
        ]);

        $context = apply_filters('app_before_render_block', $context);
        $context = apply_filters("app_before_render_block_{$block_name}", $context);
        Timber::render('@app/blocks/' . $block_template, $context);
    }
}