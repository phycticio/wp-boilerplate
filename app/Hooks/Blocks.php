<?php

namespace App\Hooks;

class Blocks
{
    public function init(): void
    {
        add_action('init', [$this, 'register_block_types']);
    }

    public function register_block_types(): void
    {
        $block_types = glob(APP_THEME_DIR . '/blocks/*');
        if (count($block_types) > 0) {
            foreach ($block_types as $block) {
                if (is_dir($block)) {
                    $block_data = register_block_type($block);

                    add_filter(
                        'allowed_block_types_all',
                        function ($allowed_blocks) use ($block_data) {
                            if (!is_array($allowed_blocks)) {
                                return $allowed_blocks;
                            }
                            $allowed_blocks[] = $block_data->name;
                            return $allowed_blocks;
                        },
                        99,
                        2,
                    );
                }
            }
        }
    }
}
