<?php

if (!function_exists('app_generate_autologin_token')) {
    function app_generate_autologin_token(WP_User $user): string {
        if (!is_dir(MC_AUTOLOGIN_TOKENS_PATH)) {
            mkdir(MC_AUTOLOGIN_TOKENS_PATH);
        }

        $hashed_email = base64_encode($user->user_email);
        $filename = MC_AUTOLOGIN_TOKENS_PATH."/{$hashed_email}.token";
        if (!file_exists($filename)) {
            touch($filename);
        }
        $token = wp_generate_password(64);
        file_put_contents($filename, $token);
        return $token;
    }
}

if (!function_exists('app_validate_autologin_token')) {
    function app_validate_autologin_token(WP_User $user, string $token): bool {
        if (!is_dir(MC_AUTOLOGIN_TOKENS_PATH)) {
            mkdir(MC_AUTOLOGIN_TOKENS_PATH, 0755, true);
        }

        $hashed_email = base64_encode($user->user_email);
        $filename = MC_AUTOLOGIN_TOKENS_PATH."/{$hashed_email}.token";

        if (!file_exists($filename)) {
            return false;
        }

        $last_modification_file = filemtime($filename);
        $now = time();

        if (($now - $last_modification_file) > 300) {
            unlink($filename);
            return false;
        }

        $stored_token = file_get_contents($filename);
        $valid = trim($token) === trim($stored_token);

        if ($valid) {
            unlink($filename);
        }

        return $valid;
    }
}

if(!function_exists('app_generate_logout_info')) {
    function app_generate_logout_info(WP_User $user) : void {
        if (!is_dir(MC_LOGOUT_PATH)) {
            mkdir(MC_LOGOUT_PATH, 0755, true);
        }

        $hashed_email = base64_encode($user->user_email);
        $filename = MC_LOGOUT_PATH."/{$hashed_email}";
        if(!file_exists($filename)) {
            touch($filename);
        }
    }
}

if (!function_exists('app_maybe_logout')) {
    function app_maybe_logout(WP_User $user) : bool {
        $hashed_email = base64_encode($user->user_email);
        $filename = MC_LOGOUT_PATH."/{$hashed_email}";
        if(!file_exists($filename)) {
            return false;
        }
        wp_logout();
        return unlink($filename);
    }
}