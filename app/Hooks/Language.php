<?php

namespace App\Hooks;

use Roots\WPConfig\Config;

class Language {
    public function init() : void {
        add_filter('locale', array($this, 'locale'));
    }

    public function locale(string $locale) : string {
        if (isset($_COOKIE['browser_language'])) {
            $browser_language = sanitize_text_field($_COOKIE['browser_language']);
            $lang_dir = Config::get('ROOT_DIR') . '/app/languages';
            $available_languages = get_available_languages($lang_dir);
            if (in_array($browser_language, $available_languages)) {
                return $browser_language;
            }
        }
        return $locale;
    }
}