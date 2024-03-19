<?php

namespace App\Api\Shared\Infrastructure\Service;

use App\Api\Shared\Domain\Service\GeolocationInterface;
use http\Exception\RuntimeException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Geolocation implements GeolocationInterface
{

    private RequestStack $requestStack;
    private HttpClientInterface $httpClient;

    public function __construct(RequestStack $requestStack, HttpClientInterface $httpClient) {
        $this->requestStack = $requestStack;
        $this->httpClient = $httpClient;
    }

    public function getInfoConnection(): array {
        $ip = $this->getClientIp();
        return $this->fetchInfo($ip);
    }

    private function getClientIp(): string {
        return '188.26.218.47';
        $request = $this->requestStack->getCurrentRequest();

        if ($request->headers->has('X-Forwarded-For')) {
            $ips = explode(',', $request->headers->get('X-Forwarded-For'));
            return trim($ips[0]);
        }

        return $request->getClientIp();
    }

    private function fetchInfo(string $ip): ?array {
        try {
            $response = $this->httpClient->request('GET', 'http://www.geoplugin.net/json.gp', [
                'query' => ['ip' => $ip]
            ]);

            $data = $response->toArray();

            if (isset($data['geoplugin_countryCode']) && strlen(trim($data['geoplugin_countryCode'])) == 2) {
                return [
                    'iso' => $data['geoplugin_countryCode'],
                    'currency' => $data['geoplugin_currencyCode'],
                    'symbol' => $data['geoplugin_currencySymbol']
                ];
            }

        } catch (\Exception $e) {
            throw new RuntimeException('ISO could not be provided by the API');
        }

        return null;
    }
}