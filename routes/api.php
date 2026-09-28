<?php
use Illuminate\Support\Facades\Route; use App\Models\{Product,Order}; use App\Jobs\ProcessDigiflazzTransaction; use Illuminate\Http\Request;
Route::get('/products',fn()=>Product::where('status',true)->paginate(50));
Route::get('/orders/{invoice}',fn($invoice)=>Order::with(['items.product','transaction'])->where('invoice',$invoice)->firstOrFail());
Route::post('/webhooks/digiflazz',function(Request $request){$secret=config('digiflazz.webhook_secret');if($secret && !hash_equals($secret,(string)$request->header('X-Digiflazz-Secret')))return response()->json(['message'=>'Unauthorized'],401);$ref=$request->input('data.ref_id',$request->input('ref_id'));$trx=\App\Models\Transaction::where('digiflazz_ref_id',$ref)->first();if(!$trx)return response()->json(['message'=>'Not found'],404);$trx->update(['response'=>$request->all(),'status'=>strtolower($request->input('data.status',$request->input('status','processing')))]);return response()->json(['ok'=>true]);});
