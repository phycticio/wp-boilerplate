<?php

namespace App\Hooks;

class Language
{
    public function init(): void
    {
        add_filter('locale', [$this, 'locale']);
    }

    public function locale(string $locale): string
    {
        return $locale;
    }
}
