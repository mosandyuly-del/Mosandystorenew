<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class IpCheckController extends Controller
{
    public function index()
    {
        $serverIp = 'Gagal mengambil IP';
        
        try {
            $response = Http::timeout(5)->get('https://api.ipify.org?format=json');
            if ($response->successful()) {
                $serverIp = $response->json('ip');
            }
        } catch (\Exception $e) {
            $serverIp = 'Error: ' . $e->getMessage();
        }

        return view('admin.ip-check', compact('serverIp'));
    }
}
