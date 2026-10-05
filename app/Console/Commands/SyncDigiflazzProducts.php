<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use App\Services\DigiflazzService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SyncDigiflazzProducts extends Command
{
    protected $signature = 'digiflazz:sync-products';

    protected $description = 'Sinkronisasi produk dari Digiflazz';

    public function handle(DigiflazzService $digiflazz): int
    {
        $this->info('Mengambil produk dari Digiflazz...');

        $products = $digiflazz->priceList();

        $count = 0;

        foreach ($products as $item) {
            $sku = $item['buyer_sku_code'] ?? null;

            if (!$sku) {
                continue;
            }

            $name = $item['product_name'] ?? 'Produk Digiflazz';
            $categoryName = $item['category'] ?? 'Lainnya';
            $brand = $item['brand'] ?? 'Umum';
            $type = $item['type'] ?? 'Umum';
            $costPrice = (float) ($item['price'] ?? 0);

            if ($costPrice <= 0) {
                continue;
            }

            $category = Category::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => $categoryName]
            );

            $margin = 1000;
            $sellingPrice = $costPrice + $margin;

            Product::updateOrCreate(
                ['digiflazz_sku' => $sku],
                [
                    'category_id' => $category->id,
                    'sku' => $sku,
                    'digiflazz_sku' => $sku,
                    'name' => $name,
                    'brand' => $brand,
                    'type' => $type,
                    'description' => $item['desc'] ?? null,
                    'cost_price' => $costPrice,
                    'selling_price' => $sellingPrice,
                    'margin_type' => 'fixed',
                    'margin_value' => $margin,
                    'status' => (bool) (
                        ($item['buyer_product_status'] ?? false)
                        && ($item['seller_product_status'] ?? false)
                    ),
                    'metadata' => $item,
                ]
            );

            $count++;
        }

        $this->info("Sinkronisasi selesai. {$count} produk diproses.");

        return self::SUCCESS;
    }
}
