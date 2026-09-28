<?php
namespace App\Http\Controllers;
use App\Models\{Order,OrderItem,Product,Transaction};
use Illuminate\Http\Request; use Illuminate\Support\Facades\DB; use Illuminate\Support\Str;
class OrderController extends Controller {
 public function create(Product $product){abort_unless($product->status,404);return view('checkout.create',compact('product'));}
 public function store(Request $request,Product $product){
  $data=$request->validate(['target'=>['required','string','max:80'],'payment_method'=>['required','in:manual,qris']]);
  abort_unless($product->status,422);
  $order=DB::transaction(function()use($data,$product){$invoice='INV-'.now()->format('Ymd').'-'.strtoupper(Str::random(6));$order=Order::create(['user_id'=>auth()->id(),'invoice'=>$invoice,'subtotal'=>$product->selling_price,'total'=>$product->selling_price,'status'=>'waiting_payment','payment_status'=>'pending','payment_method'=>$data['payment_method']]);$order->items()->create(['product_id'=>$product->id,'target'=>$data['target'],'quantity'=>1,'unit_price'=>$product->selling_price,'total'=>$product->selling_price]);$order->transaction()->create(['product_id'=>$product->id,'target'=>$data['target'],'amount'=>$product->selling_price,'cost_price'=>$product->cost_price,'selling_price'=>$product->selling_price,'profit'=>$product->selling_price-$product->cost_price,'digiflazz_ref_id'=>$invoice,'status'=>'pending']);return $order;}); return redirect()->route('orders.show',$order->invoice); }
 public function show(string $invoice){$order=Order::with(['items.product','transaction'])->where('invoice',$invoice)->firstOrFail();return view('transactions.show',compact('order'));}
 public function lookup(Request $request){$data=$request->validate(['query'=>'required|string|max:80']);$order=Order::with('transaction')->where('invoice',$data['query'])->orWhereHas('items',fn($q)=>$q->where('target',$data['query']))->latest()->first();return $order?redirect()->route('orders.show',$order->invoice)->with('success','Transaksi ditemukan.'):back()->withErrors(['query'=>'Transaksi tidak ditemukan.']);}
}
