<?php
/**
 * Plugin Name:       Ozon Sync
 * Description:       Sync Ozon catalog with WooCommerce.
 * Version:           0.1.0
 * Author:            PShaker Components
 * Text Domain:       ozon-sync
 */

if (!defined('ABSPATH')) {
    exit;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

use OzonSync\Admin\SettingsPage;
use OzonSync\Cron\Scheduler;
use OzonSync\CLI\Commands;

// Initialize admin settings page
if (is_admin()) {
    new SettingsPage();
}

// Register cron events
register_activation_hook(__FILE__, [Scheduler::class, 'activate']);
register_deactivation_hook(__FILE__, [Scheduler::class, 'deactivate']);
Scheduler::init();

// Register WP-CLI commands if available
if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('ozon', Commands::class);
}
