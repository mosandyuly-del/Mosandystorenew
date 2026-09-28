<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Transaction extends Model { protected $fillable=['order_id','product_id','target','amount','cost_price','selling_price','profit','digiflazz_ref_id','digiflazz_trx_id','serial_number','status','response','processed_at']; protected $casts=['response'=>'array','processed_at'=>'datetime','amount'=>'decimal:2','cost_price'=>'decimal:2','selling_price'=>'decimal:2','profit'=>'decimal:2']; public function order(){return $this->belongsTo(Order::class);} public function product(){return $this->belongsTo(Product::class);} }
