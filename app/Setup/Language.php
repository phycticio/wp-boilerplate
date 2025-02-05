<?php

namespace App\Setup;

class Language {
    public static function init() : void {
        add_filter('locale', self::locale(...));
    }

    public static function locale(string $locale) : string {
        if (isset($_COOKIE['browser_language'])) {
            $browser_language = sanitize_text_field($_COOKIE['browser_language']);
            $lang_dir = ROOT_DIR . '/app/languages';
            $available_languages = get_available_languages($lang_dir);
            if (in_array($browser_language, $available_languages)) {
                return $browser_language;
            }
        }
        return $locale;
    }
}