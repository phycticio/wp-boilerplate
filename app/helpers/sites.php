<?php

use function Env\env;

if (!function_exists('app_user_has_a_site')) {
    function app_user_has_a_site(int $user_id): ?int {
        $user_has_a_site = get_posts(array(
            'post_type' => 'site',
            'author' => $user_id,
            'posts_per_page' => 1,
        ));

        if (count($user_has_a_site) > 0) {
            $site = $user_has_a_site[0];
            $site_url = get_field('site_uri', $site->ID);
            if ($site_url) {
                return $site->ID;
            }
            return null;
        }
        return null;
    }
}

if (!function_exists('app_site_is_active')) {
    function app_site_is_active(int $site_id): bool {
        $site_conf = get_fields($site_id);
        if (!$site_conf) {
            return false;
        }
        extract($site_conf);

        if (!$db_name || !$db_user || !$db_password || !$wp_home || !$domain_current_site) {
            return false;
        }

        try {
            $pdo = new \PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(\PDO::FETCH_COLUMN);
            return count($tables) > 0;
        } catch (\PDOException $e) {
            return false;
        }
    }
}

if (!function_exists('app_generate_env_file_info')) {
    function app_generate_env_file_info(int $queue_id, string $space_name, string $company_name): array {
        $user_data = get_user(get_current_user_id());
        if (!$user_data) return array();
        $domain_current_site = $space_name.'.'.env('APP_DOMAIN');
        $wp_home = env('APP_PROTOCOL').$domain_current_site;
        return array(
            'wp_home' => $wp_home,
            'domain_current_site' => $domain_current_site,
            'company_name' => $company_name,
            'space_name' => $space_name,
            'database_name' => "{$space_name}_db",
            'database_user' => "{$space_name}_user",
            'database_password' => wp_generate_password(16),
            'database_host' => DEFAULT_DB_HOST,
            'database_prefix' => app_generate_db_prefix(4),
            'auth_key' => wp_generate_password(64),
            'logged_in_key' => wp_generate_password(64),
            'secure_auth_key' => wp_generate_password(64),
            'nonce_key' => wp_generate_password(64),
            'auth_salt' => wp_generate_password(64),
            'secure_auth_salt' => wp_generate_password(64),
            'logged_in_salt' => wp_generate_password(64),
            'nonce_salt' => wp_generate_password(64),
            'admin_email' => $user_data->user_email,
            'space_path' => MC_SITES_PATH.'/'.$space_name
        );
    }
}

if (!function_exists('app_generate_db_prefix')) {
    function app_generate_db_prefix(int $length = 6): string {
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789_';
        $prefix = '';

        for ($i = 0; $i < $length; $i++) {
            $prefix .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $prefix.'_';
    }
}

if (!function_exists('app_get_initial_page')) {
    function app_get_initial_page(\WP_User $user): string {
        $dashboard_page_id = get_option('invoice_page_id');
        $dashboard_url = get_permalink($dashboard_page_id);
        $is_child_site = env('CHILD_SITE');

        $initial_page = $dashboard_url;
        if (!$is_child_site) {
            if (app_maybe_logout($user)) {
                return wp_login_url();
            }
            if (user_can($user, 'administrator')) {
                $initial_page = admin_url();
            } else {
                $site_id = app_user_has_a_site($user->ID);

                $site_uri = get_field('site_uri', $site_id);
                $site_is_active = $site_id && app_site_is_active($site_id);

                if ($site_id && $site_is_active) {
                    $autologin_token = app_generate_autologin_token($user);
                    $initial_page = add_query_arg(array(
                        'email' => $user->user_email,
                        'autologin_key' => urlencode($autologin_token),
                    ), "{$site_uri}/auth/sign-in");
                } elseif ($site_id && !$site_is_active) {
                    $autologin_token = app_generate_autologin_token($user);
                    $initial_page = add_query_arg(array(
                        'autologin_key' => urlencode($autologin_token),
                        'installing' => true,
                    ), "{$site_uri}/content/space-install-setup.php");
                } else {
                    $create_page_id = get_option('create_page_id');
                    $initial_page = get_permalink($create_page_id);
                }
            }
        }
        return $initial_page;
    }
}