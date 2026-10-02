@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8">

    <div class="bg-white border rounded-2xl p-6 mb-6">
        <h1 class="text-2xl font-black">
            Halo, {{ auth()->user()->name }} 👋
        </h1>

        <p class="text-gray-500 mt-1">
            Selamat datang di MosandyStore.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <a href="{{ route('products.index') }}"
           class="bg-white border rounded-2xl p-5 hover:shadow">
            <div class="text-3xl mb-2">📱</div>
            <h2 class="font-bold">Beli Pulsa</h2>
            <p class="text-sm text-gray-500">
                Pulsa dan paket data
            </p>
        </a>

        <a href="{{ route('orders.lookup') }}"
           class="bg-white border rounded-2xl p-5 hover:shadow">
            <div class="text-3xl mb-2">🧾</div>
            <h2 class="font-bold">Cek Transaksi</h2>
            <p class="text-sm text-gray-500">
                Cek status pesanan
            </p>
        </a>

        @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}"
           class="bg-white border rounded-2xl p-5 hover:shadow">
            <div class="text-3xl mb-2">⚙️</div>
            <h2 class="font-bold">Admin Dashboard</h2>
            <p class="text-sm text-gray-500">
                Kelola MosandyStore
            </p>
        </a>
        @endif

    </div>

    <div class="mt-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-600 text-white px-5 py-3 rounded-xl font-bold">
                Logout
            </button>
        </form>
    </div>

</div>
@endsection
