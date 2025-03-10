<?php

namespace App\Hooks;

use Roots\WPConfig\Config;

class Setup
{
    public function init(): void
    {
        if (Config::get('DISALLOW_INDEXING') !== true) {
            return;
        }
        add_action('admin_init', [$this, 'admin_init']);
        add_action('pre_option_blog_public', '__return_zero');
    }

    public function admin_init(): void
    {
        if (!apply_filters('app/disallow_indexing_admin_notice', true)) {
            return;
        }

        add_action('admin_notices', function () {
            $message = sprintf(
                __('%1$s Search engine indexing has been discouraged because the current environment is %2$s.', 'roots'),
                '<strong>Boilerplate:</strong>',
                '<code>' . WP_ENV . '</code>',
            );
            echo "<div class='notice notice-warning'><p>{$message}</p></div>";
        });
    }
}
