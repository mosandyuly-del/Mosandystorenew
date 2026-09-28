<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Product extends Model { protected $fillable=['category_id','sku','digiflazz_sku','name','brand','type','description','cost_price','selling_price','margin_type','margin_value','status','metadata']; protected $casts=['metadata'=>'array','cost_price'=>'decimal:2','selling_price'=>'decimal:2','margin_value'=>'decimal:2']; public function category(){return $this->belongsTo(Category::class);} }
