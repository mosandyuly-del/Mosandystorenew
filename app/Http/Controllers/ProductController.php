<?php
namespace App\Http\Controllers;
use App\Models\{Category,Product};
class ProductController extends Controller { public function index(Category $category=null){$products=Product::where('status',true)->when($category,fn($q)=>$q->where('category_id',$category->id))->with('category')->paginate(24);return view('products.index',compact('products','category'));} }
