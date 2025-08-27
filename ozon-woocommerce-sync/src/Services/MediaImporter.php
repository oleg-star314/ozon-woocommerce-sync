<?php
namespace OzonSync\Services;

use OzonSync\Logger\Logger;

class MediaImporter
{
    private Logger $logger;

    public function __construct(?Logger $logger = null)
    {
        $this->logger = $logger ?: new Logger();
    }

    public function importImages(int $productId, array $urls): void
    {
        $this->logger->info('Import images for product ' . $productId . ': ' . implode(', ', $urls));
    }
}
