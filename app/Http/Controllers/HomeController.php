<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil daftar kategori unik
        $categories = DB::table('products')
            ->select('category')
            ->where('buyer_product_status', true)
            ->where('seller_product_status', true)
            ->groupBy('category')
            ->pluck('category');

        // Filter produk berdasarkan kategori jika dipilih
        $selectedCategory = $request->get('category', $categories->first());

        $products = DB::table('products')
            ->where('buyer_product_status', true)
            ->where('seller_product_status', true)
            ->when($selectedCategory, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->get();

        return view('welcome', compact('categories', 'products', 'selectedCategory'));
    }
}
