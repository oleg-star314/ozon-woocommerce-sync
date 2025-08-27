<?php
namespace OzonSync\Services;

use OzonSync\Logger\Logger;

class SyncRunner
{
    private Logger $logger;

    public function __construct(?Logger $logger = null)
    {
        $this->logger = $logger ?: new Logger();
    }

    public function runFull(): array
    {
        $this->logger->info('Full sync start');
        $count = 0;
        if (function_exists('update_option')) {
            update_option('ozon_last_sync', time());
        }
        $this->logger->info('Full sync finish');
        return ['processed' => $count];
    }

    public function runDelta(): array
    {
        $this->logger->info('Delta sync start');
        $count = 0;
        if (function_exists('update_option')) {
            update_option('ozon_last_sync', time());
        }
        $this->logger->info('Delta sync finish');
        return ['processed' => $count];
    }
}
