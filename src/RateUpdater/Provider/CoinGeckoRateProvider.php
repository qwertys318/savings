<?php namespace App\RateUpdater\Provider;

use App\RateUpdater\RateProviderInterface;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Utils;

class CoinGeckoRateProvider implements RateProviderInterface
{
    public function request(array $params): string
    {
        $guzzle = new Guzzle();
        $response = $guzzle->get("https://api.coingecko.com/api/v3/coins/{$params['id']}", ['query' => [
            'localization' => 'en',
            'tickers' => 'false',
            'market_data' => 'true',
            'community_data' => 'false',
            'developer_data' => 'false',
            'sparkline' => 'false',
        ]]);
        $data = Utils::jsonDecode($response->getBody()->getContents(), true);
        $rate = (string)$data['market_data']['current_price']['usd'];

        return $rate;
    }
}
