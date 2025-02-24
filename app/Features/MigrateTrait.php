<?php

namespace App\Features;

use function Env\env;

trait MigrateTrait {
    public static function migrate() : void {
        $migration_files = glob(MC_MIGRATIONS_PATH . '/*.php');

        if (!$migration_files) {
            return;
        }

        global $wpdb;

        $table_name = $wpdb->prefix . 'migrations';

        $applied_migrations = $wpdb->get_col("SELECT migration_name FROM $table_name");

        $site_name = get_bloginfo();

        if(!env('CHILD_SITE')) {
//            return;
        }

        $last_migration = app_get_last_migration_from_code();

        if ($last_migration && app_has_last_migration_run($last_migration)) {
            app_log("Last migration '{$last_migration}' has already been applied.");
            return;
        }

        foreach ($migration_files as $migration_file) {
            $migration_name = basename($migration_file, '.php');

            if (in_array($migration_name, $applied_migrations)) {
                continue;
            }

            app_log("Running migration: {$migration_name} on {$site_name}");

            $migration_function = include $migration_file;

            try {
                $wpdb->query('START TRANSACTION');
                $migration_function($wpdb);
                $wpdb->insert($table_name, [
                    'migration_name' => $migration_name,
                    'applied_at' => current_time('mysql'),
                ]);
                $wpdb->query('COMMIT');
                update_option('last_migration_ran', $migration_name);
            } catch (\Exception $e) {
                $wpdb->query('ROLLBACK');
                app_log("Error running migration: $migration_name: " . $e->getMessage());
            }
        }
    }
}