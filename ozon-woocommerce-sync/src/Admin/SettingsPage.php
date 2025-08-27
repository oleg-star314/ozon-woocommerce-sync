<?php
namespace OzonSync\Admin;

use OzonSync\Api\Client;
use OzonSync\Services\SyncRunner;

class SettingsPage
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'register']);
        add_action('admin_post_ozon_sync_action', [$this, 'handle']);
        add_action('admin_notices', [$this, 'notice']);
    }

    public function register()
    {
        add_submenu_page('woocommerce', 'Ozon Sync', 'Ozon Sync', 'manage_woocommerce', 'ozon-sync', [$this, 'render']);
    }

    public function render()
    {
        include plugin_dir_path(__FILE__) . '../../views/settings-page.php';
    }

    public function handle()
    {
        if (!current_user_can('manage_woocommerce')) {
            wp_die('Forbidden');
        }
        check_admin_referer('ozon_sync_action');
        $action = sanitize_text_field($_POST['ozon_sync_button'] ?? '');
        $client = new Client(get_option('ozon_api_base'), get_option('ozon_client_id'), get_option('ozon_api_key'));
        $runner = new SyncRunner();
        switch ($action) {
            case 'check':
                $message = $client->checkConnection() ? 'Connection successful' : 'Connection failed';
                break;
            case 'full':
                $res = $runner->runFull();
                $message = 'Full sync processed ' . $res['processed'] . ' items';
                break;
            case 'delta':
                $res = $runner->runDelta();
                $message = 'Delta sync processed ' . $res['processed'] . ' items';
                break;
            default:
                $message = '';
        }
        set_transient('ozon_sync_notice', $message, 30);
        wp_redirect(wp_get_referer());
        exit;
    }

    public function notice()
    {
        if ($msg = get_transient('ozon_sync_notice')) {
            echo "<div class='notice notice-success is-dismissible'><p>" . esc_html($msg) . "</p></div>";
            delete_transient('ozon_sync_notice');
        }
    }
}
