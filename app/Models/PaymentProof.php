<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PaymentProof extends Model { protected $fillable=['order_id','path','status','verified_by']; public function order(){return $this->belongsTo(Order::class);} }
