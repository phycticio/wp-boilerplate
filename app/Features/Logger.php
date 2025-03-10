<?php

namespace App\Features;

trait Logger
{
    protected function log($message, $level = 'info'): void
    {
        if (!defined('WP_DEBUG') || !WP_DEBUG) {
            return;
        }

        $log_message = strtoupper($level) . ': ' . $message;

        if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
            error_log($log_message);
        }

        do_action('app/logger', $log_message, $level);
    }
}
