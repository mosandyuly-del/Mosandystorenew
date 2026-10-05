<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DigiflazzService
{
    public function priceList(): array
    {
        $username = config('services.digiflazz.username');
        $apiKey = config('services.digiflazz.api_key');
        $baseUrl = config('services.digiflazz.base_url');

        $sign = md5($username . $apiKey . 'pricelist');

        $response = Http::timeout(30)
            ->post($baseUrl . '/price-list', [
                'cmd' => 'prepaid',
                'username' => $username,
                'sign' => $sign,
            ]);

        $response->throw();

        return $response->json('data', []);
    }
}
