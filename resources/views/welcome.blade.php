<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MosandyStore - Layanan Digital & PPOB</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-blue-600 text-white p-4 shadow-md sticky top-0 z-50">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold tracking-wide">MosandyStore</h1>
            <a href="/admin/cek-ip-digiflazz" class="text-xs bg-blue-700 hover:bg-blue-800 px-3 py-1.5 rounded text-white">Dashboard Admin</a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto p-4 md:p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Pilih Produk & Layanan</h2>

        <!-- Tab Kategori -->
        @if(isset($categories) && count($categories) > 0)
        <div class="flex overflow-x-auto space-x-2 pb-3 mb-6 scrollbar-none">
            @foreach($categories as $cat)
                <a href="?category={{ urlencode($cat) }}" 
                   class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition
                          {{ $selectedCategory == $cat ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
        @endif

        <!-- Daftar Grid Produk -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4">
            @forelse($products as $product)
                <div class="bg-white border border-gray-200 rounded-lg p-3 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-100 uppercase tracking-wider block w-max mb-1">
                            {{ $product->brand }}
                        </span>
                        <h3 class="text-xs sm:text-sm font-semibold text-gray-800 line-clamp-2 mb-2">
                            {{ $product->product_name }}
                        </h3>
                    </div>
                    
                    <div class="mt-2 border-t pt-2 flex items-center justify-between">
                        <span class="text-xs sm:text-sm font-bold text-green-600">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <button class="text-[11px] bg-blue-600 hover:bg-blue-700 text-white font-medium px-2 py-1 rounded">
                            Beli
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-lg border">
                    <p class="text-gray-500 text-sm">Belum ada produk yang tersedia.</p>
                    <p class="text-xs text-gray-400 mt-1">Silakan lakukan sinkronisasi dari dashboard admin.</p>
                </div>
            @endforelse
        </div>
    </main>
</body>
</html>
