<?php namespace App\RateUpdater\Provider;

use App\RateUpdater\RateProviderInterface;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Utils;

class ExchangeRateRateProvider implements RateProviderInterface
{
    public function __construct(
        private string $exchangeRateApiKey,
    )
    {
    }

    public function request(array $params): string
    {
        $guzzle = new Guzzle();
        $url = "https://v6.exchangerate-api.com/v6/{$this->exchangeRateApiKey}/latest/{$params['code']}";
        $response = $guzzle->get($url);
        $data = Utils::jsonDecode($response->getBody()->getContents(), true);
        $rate = (string)$data['conversion_rates']['USD'];

        return $rate;
    }
}
