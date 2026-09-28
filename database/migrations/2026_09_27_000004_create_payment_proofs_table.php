<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up():void{Schema::create('payment_proofs',function(Blueprint $t){$t->id();$t->foreignId('order_id')->constrained()->cascadeOnDelete();$t->string('path');$t->string('status')->default('pending');$t->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();$t->timestamps();});} public function down():void{Schema::dropIfExists('payment_proofs');} };
