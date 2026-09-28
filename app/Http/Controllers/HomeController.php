<?php
namespace App\Http\Controllers;
use App\Models\Category;
class HomeController extends Controller { public function index(){ $categories=Category::where('status',true)->with(['products'=>fn($q)=>$q->where('status',true)->latest()->limit(8)])->get(); return view('home',compact('categories')); } }
