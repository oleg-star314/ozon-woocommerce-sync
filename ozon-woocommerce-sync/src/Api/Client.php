<?php
namespace OzonSync\Api;

use OzonSync\Logger\Logger;

class Client
{
    private string $baseUrl;
    private string $clientId;
    private string $apiKey;
    private Logger $logger;

    public function __construct(string $baseUrl, string $clientId, string $apiKey, ?Logger $logger = null)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->clientId = $clientId;
        $this->apiKey = $apiKey;
        $this->logger = $logger ?: new Logger();
    }

    public function post($path, array $payload): array
    {
        $url = $this->baseUrl . $path;
        $args = [
            'headers' => [
                'Client-Id' => $this->clientId,
                'Api-Key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'body' => function_exists('wp_json_encode') ? wp_json_encode($payload) : json_encode($payload),
            'timeout' => 20,
        ];

        $attempts = 0;
        do {
            $response = function_exists('wp_remote_post') ? wp_remote_post($url, $args) : null;
            if (is_array($response)) {
                $code = $response['response']['code'] ?? 500;
                if ($code >= 200 && $code < 300) {
                    $body = $response['body'] ?? '{}';
                    return json_decode($body, true) ?? [];
                }
            }
            $attempts++;
            sleep($attempts);
        } while ($attempts < 3);

        return [];
    }

    public function checkConnection(): bool
    {
        try {
            $this->post(Endpoints::V3_PRODUCT_LIST, ['limit' => 1]);
            return true;
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
            return false;
        }
    }
}
