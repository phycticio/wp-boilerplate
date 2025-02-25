<?php

namespace App\Hooks;

class Gutenberg {
    public function init() : void {
        add_action('after_setup_theme', self::after_setup_theme(...));
        add_action('enqueue_block_editor_assets', self::enqueue_block_editor_assets(...));
        try {
            add_filter('allowed_block_types_all', self::allowed_block_types_all(...));
            add_filter('block_categories_all', self::block_categories_all(...), 10, 2);
        } catch(\Exception $e) {
            wp_die($e->getMessage(), __(sprintf('Error: %s', $e->getCode())));
        }
    }

    public static function after_setup_theme() : void {
        remove_theme_support('core-block-patterns');
        flush_rewrite_rules();
    }

    public static function enqueue_block_editor_assets() : void {
        $script = "window.onload = function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } }";
        wp_add_inline_script( 'wp-blocks', $script );

        $editor = require_once APP_THEME_DIR . '/dist/editor.asset.php';
        wp_enqueue_script(
            'app-editor',
            APP_THEME_URL . '/dist/editor.js',
            $editor['dependencies'],
            $editor['version']
        );
    }

    public static function allowed_block_types_all($allowed_blocks) : bool|array {
        return $allowed_blocks;
    }

    public static function block_categories_all(array $categories, $post) : array {
        return $categories;
    }
}