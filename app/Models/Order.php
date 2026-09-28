<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model { protected $fillable=['user_id','invoice','subtotal','admin_fee','discount','total','status','payment_status','payment_method']; protected $casts=['subtotal'=>'decimal:2','admin_fee'=>'decimal:2','discount'=>'decimal:2','total'=>'decimal:2']; public function items(){return $this->hasMany(OrderItem::class);} public function user(){return $this->belongsTo(User::class);} public function transaction(){return $this->hasOne(Transaction::class);} }
