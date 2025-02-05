<?php

if (!function_exists('app_get_last_migration_from_code')) {
    function app_get_last_migration_from_code(): ?string {
        $migration_files = glob(MC_MIGRATIONS_PATH.'/*.php');

        if (!$migration_files) {
            return null;
        }

        usort($migration_files, function ($a, $b) {
            return filemtime($b) - filemtime($a);
        });

        return basename($migration_files[0], '.php');
    }
}

if (!function_exists('app_has_last_migration_run')) {
    function app_has_last_migration_run($last_migration): bool {
        global $wpdb;

        $table_name = $wpdb->prefix.'migrations';
        $applied_migrations = $wpdb->get_col("SELECT migration_name FROM $table_name");

        return in_array($last_migration, $applied_migrations);
    }
}