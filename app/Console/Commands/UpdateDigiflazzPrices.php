<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\DigiflazzService;
use Illuminate\Console\Command;

class UpdateDigiflazzPrices extends Command
{
    protected $signature = 'digiflazz:update-prices';

    protected $description = 'Update harga produk dari Digiflazz';

    public function handle(DigiflazzService $digiflazz): int
    {
        $this->info('Mengambil harga terbaru dari Digiflazz...');

        $items = $digiflazz->priceList();

        if (empty($items)) {
            $this->error('Data harga dari Digiflazz kosong.');
            return self::FAILURE;
        }

        $updated = 0;
        $notFound = 0;
        $unchanged = 0;

        foreach ($items as $item) {
            $sku = $item['buyer_sku_code'] ?? null;
            $price = $item['price'] ?? null;

            if (!$sku || !is_numeric($price)) {
                continue;
            }

            $product = Product::where('digiflazz_sku', $sku)->first();

            if (!$product) {
                $notFound++;
                continue;
            }

            $newCost = (float) $price;

            /*
             * Pertahankan margin produk yang sudah ada.
             * Untuk margin fixed, gunakan margin_value.
             */
            if ($product->margin_type === 'fixed') {
                $margin = (float) $product->margin_value;
                $newSellingPrice = $newCost + $margin;
            } else {
                /*
                 * Jika menggunakan persentase.
                 */
                $marginPercent = (float) $product->margin_value;
                $newSellingPrice = $newCost + ($newCost * $marginPercent / 100);
            }

            $oldCost = (float) $product->cost_price;

            if ($oldCost == $newCost) {
                $unchanged++;
            } else {
                $updated++;
            }

            $product->update([
                'cost_price' => $newCost,
                'selling_price' => round($newSellingPrice, 2),
                'status' => (bool) (
                    ($item['buyer_product_status'] ?? false)
                    && ($item['seller_product_status'] ?? false)
                ),
                'metadata' => $item,
            ]);
        }

        $this->newLine();
        $this->info('Update harga selesai.');
        $this->line("Harga diperbarui : {$updated}");
        $this->line("Harga tetap       : {$unchanged}");
        $this->line("SKU tidak ditemukan: {$notFound}");

        return self::SUCCESS;
    }
}
