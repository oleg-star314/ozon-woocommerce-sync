<?php
namespace OzonSync\CLI;

use OzonSync\Services\SyncRunner;
use OzonSync\Api\Client;

class Commands
{
    public function sync($args, $assoc_args)
    {
        $runner = new SyncRunner();
        $mode = $assoc_args['mode'] ?? 'delta';
        if ($mode === 'full') {
            $runner->runFull();
        } else {
            $runner->runDelta();
        }
    }

    public function check_connection()
    {
        $client = new Client(get_option('ozon_api_base'), get_option('ozon_client_id'), get_option('ozon_api_key'));
        $ok = $client->checkConnection();
        \\WP_CLI::log($ok ? 'OK' : 'FAIL');
    }
}
