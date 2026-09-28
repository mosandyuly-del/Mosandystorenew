<?php
namespace App\Http\Controllers;
use App\Models\{Order,Product,User};
class AdminController extends Controller { public function index(){abort_unless(auth()->user()?->role==='admin',403);$stats=['users'=>User::count(),'orders'=>Order::count(),'success'=>Order::where('status','success')->count(),'pending'=>Order::whereIn('status',['waiting_payment','processing'])->count(),'revenue'=>Order::where('payment_status','paid')->sum('total')];return view('admin.dashboard',compact('stats'));} public function products(){abort_unless(auth()->user()?->role==='admin',403);$products=Product::with('category')->latest()->paginate(30);return view('admin.products',compact('products'));} }
