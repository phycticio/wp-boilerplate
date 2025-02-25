<?php

namespace App\Hooks;

use Roots\WPConfig\Config;

class Views {
    public function init(): void {
        if (\Timber::class) {
            add_action('timber/context', self::timber_context(...));
            add_filter('timber/twig', self::timber_twig(...));
            add_filter('timber/locations', self::timber_locations(...), 100);
        } else {
            add_action('admin_notices', self::admin_notice(...));
        }
    }

    public static function admin_notice(): void {
        echo <<<EOF
<div class="error">
  <p>
    Timber not activated. Please run <pre>composer require timber/timber</pre> in the project root terminal.
  </p>
</div>
EOF;
    }

    public static function timber_context(array $context): array {
        return $context;
    }

    public static function timber_twig(\Twig\Environment $twig): \Twig\Environment {
        $twig->addFilter(new \Twig\TwigFilter('admin_url', function ($filename) {
            return admin_url($filename);
        }));

        $twig->addFilter(new \Twig\TwigFilter('print_id', function ($string) {
            $id = " id=\"{$string}\" ";
            return $string ? $id : '';
        }));

        return $twig;
    }

    public static function timber_locations(array $paths): array {
        $paths['app'] = [
            Config::get('RESOURCES_PATH')   .'/views',
        ];

        return $paths;
    }

    private static function _get_user_display_name($user) : string {
        if($user->first_name && $user->last_name) {
            return ucwords(strtolower("{$user->first_name} {$user->last_name}"));
        }

        return $user->user_email;
    }

    private static function _get_user_role_name($user) : string {
        return $user->roles[0] ?? false;
    }

    private static function _get_static_pages() : array {
        $dashboard_page_id = get_option('dashboard_page_id');
        $apps_page_id = get_option('apps_page_id');
        $users_page_id = get_option('users_page_id');
        $settings_page_id = get_option('settings_page_id');
        $activity_page_id = get_option('activity_page_id');
        $support_page_id = get_option('support_page_id');

        return array(
            array(
                'link' => get_permalink($dashboard_page_id),
                'title' => __('Dash'),
                'icon' => get_page_icon($dashboard_page_id, '35px'),
            ),
            array(
                'link' => get_permalink($apps_page_id),
                'title' => get_the_title($apps_page_id),
                'icon' => get_page_icon($apps_page_id, '35px'),
            ),
            array(
                'link' => get_permalink($users_page_id),
                'title' => get_the_title($users_page_id),
                'icon' => get_page_icon($users_page_id, '35px'),
            ),
            array(
                'link' => get_permalink($settings_page_id),
                'title' => get_the_title($settings_page_id),
                'icon' => get_page_icon($settings_page_id, '35px'),
            ),
            array(
                'link' => get_permalink($activity_page_id),
                'title' => get_the_title($activity_page_id),
                'icon' => get_page_icon($activity_page_id, '35px'),
            ),
            array(
                'link' => get_permalink($support_page_id),
                'title' => get_the_title($support_page_id),
                'icon' => get_page_icon($support_page_id, '35px'),
            ),
        );
    }

    private static function _get_account_page() : string {
        $account_page_id = get_option('account_page_id');
        return get_permalink($account_page_id);
    }

    private static function _get_page_routes() : array {
        $routes = get_post_meta(get_the_ID(), 'routes', true);
        return !!$routes ? $routes : array();
    }
}