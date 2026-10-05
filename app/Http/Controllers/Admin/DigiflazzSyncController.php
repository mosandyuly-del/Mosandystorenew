<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class DigiflazzSyncController extends Controller
{
    public function sync()
    {
        $username = env('DIGIFLAZZ_USERNAME');
        $apiKey   = env('DIGIFLAZZ_KEY');

        if (!$username || !$apiKey) {
            return back()->with('error', 'DIGIFLAZZ_USERNAME atau DIGIFLAZZ_KEY belum diatur di .env / Railway Variables!');
        }

        // Generate Sign untuk request pricelist Digiflazz
        $sign = md5($username . $apiKey . 'pricelist');

        try {
            $response = Http::post('https://api.digiflazz.com/v1/price-list', [
                'cmd' => 'prepaid',
                'username' => $username,
                'sign' => $sign,
            ]);

            if ($response->successful() && isset($response->json()['data'])) {
                $products = $response->json()['data'];

                DB::beginTransaction();
                foreach ($products as $item) {
                    // Masukkan/Update data produk ke tabel products/pricelist
                    DB::table('products')->updateOrInsert(
                        ['buyer_sku_code' => $item['buyer_sku_code']],
                        [
                            'product_name'   => $item['product_name'],
                            'category'       => $item['category'],
                            'brand'          => $item['brand'],
                            'price'          => $item['price'], // Harga modal dari Digiflazz
                            'seller_product_status' => $item['seller_product_status'],
                            'buyer_product_status'  => $item['buyer_product_status'],
                            'desc'           => $item['desc'] ?? '',
                            'updated_at'     => now(),
                        ]
                    );
                }
                DB::commit();

                return back()->with('success', 'Berhasil mensinkronkan ' . count($products) . ' produk dari Digiflazz!');
            }

            return back()->with('error', 'Gagal mengambil data dari Digiflazz: ' . ($response->json()['data']['message'] ?? 'Response error'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
