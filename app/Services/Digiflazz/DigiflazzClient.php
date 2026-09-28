<?php
namespace App\Services\Digiflazz;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class DigiflazzClient
{
    private function key(): string
    {
        return config('digiflazz.mode') === 'production'
            ? (string) config('digiflazz.production_key')
            : (string) config('digiflazz.development_key');
    }

    private function sign(string $endpoint, ?string $ref = null): string
    {
        $username = (string) config('digiflazz.username');
        $key = $this->key();
        return $ref === null
            ? md5($username . $key . $endpoint)
            : md5($username . $key . $ref);
    }

    public function post(string $url, array $payload): array
    {
        if (!$url || !config('digiflazz.username') || !$this->key()) {
            throw new RuntimeException('Digiflazz belum dikonfigurasi.');
        }
        $response = Http::timeout(30)->acceptJson()->post($url, $payload);
        if ($response->failed()) {
            throw new RuntimeException('Digiflazz API HTTP error: '.$response->status());
        }
        return $response->json() ?? [];
    }

    public function getProducts(): array
    {
        return $this->post(config('digiflazz.price_url'), [
            'cmd' => 'prepaid',
            'username' => config('digiflazz.username'),
            'sign' => $this->sign('pricelist'),
        ]);
    }

    public function checkBalance(): array
    {
        return $this->post(config('digiflazz.balance_url'), [
            'cmd' => 'deposit',
            'username' => config('digiflazz.username'),
            'sign' => $this->sign('depo'),
        ]);
    }

    public function transaction(string $buyerSkuCode, string $customerNo, string $refId): array
    {
        return $this->post(config('digiflazz.transaction_url'), [
            'username' => config('digiflazz.username'),
            'buyer_sku_code' => $buyerSkuCode,
            'customer_no' => $customerNo,
            'ref_id' => $refId,
            'sign' => $this->sign('', $refId),
        ]);
    }
}
