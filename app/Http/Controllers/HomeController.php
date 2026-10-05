<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = collect();
        $products = collect();
        $selectedCategory = $request->get('category');

        // Cek apakah tabel products dan kolom category sudah terbuat
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'category')) {
            $categories = DB::table('products')
                ->select('category')
                ->whereNotNull('category')
                ->where('buyer_product_status', true)
                ->where('seller_product_status', true)
                ->groupBy('category')
                ->pluck('category');

            if (!$selectedCategory) {
                $selectedCategory = $categories->first();
            }

            $products = DB::table('products')
                ->where('buyer_product_status', true)
                ->where('seller_product_status', true)
                ->when($selectedCategory, function ($query, $category) {
                    return $query->where('category', $category);
                })
                ->get();
        }

        return view('welcome', compact('categories', 'products', 'selectedCategory'));
    }
}
