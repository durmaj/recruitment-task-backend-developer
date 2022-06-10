<?php

declare(strict_types=1);

namespace App\ExternalContent\Article\Application\Service\NYTService;

use App\ExternalContent\Article\Domain\Exception\InvalidCredentialsException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\NoPrivateNetworkHttpClient;

class NYTApiProxyService
{
    private string $apiKey;

    private string $apiUrl;

    public function __construct(string $apiKey, string $apiUrl)
    {
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;
    }

    /**
     * @throws InvalidCredentialsException
     */
    public function createRequest(string $method, NYTApiQuery $params): array
    {
        $client = new NoPrivateNetworkHttpClient(HttpClient::create());
        $response = $client->request(
            $method,
            $this->buildQueryURL($params)
        );

        return $response->toArray();
    }

    private function buildQueryURL(NYTApiQuery $params): string
    {
        $url = $this->apiUrl . $params->getPath() . "?" . $params->getKeywords() . "&api-key=" . $this->apiKey;

        if ($params->getResponseFields()) {
            $url .= "&" . $params->getResponseFields();
        }

        if ($params->getSort()) {
            $url .= "&" . $params->getSort();
        }

        return $url;
    }
}
