<?php

namespace App\Hooks;

use Roots\WPConfig\Config;

class Views
{
    public function init(): void
    {
        if (\Timber::class) {
            add_action('timber/context', [$this, 'timber_context']);
            add_filter('timber/twig', [$this, 'timber_twig']);
            add_filter('timber/locations', [$this, 'timber_locations'], 100);
        } else {
            add_action('admin_notices', [$this, 'admin_notice']);
        }
    }

    public function admin_notice(): void
    {
        $message = sprintf(
            __('Timber not activated. Please run %1$s in the project root terminal.', 'app'),
            '<pre>composer require timber/timber</pre>',
        );
        echo "<div class='notice notice-warning'><p>{$message}</p></div>";
    }

    public function timber_context(array $context): array
    {
        return $context;
    }

    public function timber_twig(\Twig\Environment $twig): \Twig\Environment
    {
        $twig->addFilter(new \Twig\TwigFilter('admin_url', function ($filename) {
            return admin_url($filename);
        }));

        $twig->addFilter(new \Twig\TwigFilter('print_id', function ($string) {
            $id = " id=\"{$string}\" ";
            return $string ? $id : '';
        }));

        return $twig;
    }

    public function timber_locations(array $paths): array
    {
        $paths['app'] = [
            Config::get('RESOURCES_PATH') . '/views',
        ];

        return $paths;
    }
}
