<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder; use App\Models\{User,Category,Product}; use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder { public function run():void { $admin=User::firstOrCreate(['email'=>env('ADMIN_EMAIL','admin@example.com')],['name'=>'Administrator','phone'=>null,'password'=>env('ADMIN_PASSWORD','change-me-now'),'role'=>'admin','status'=>true]); foreach([['Pulsa','pulsa'],['Paket Data','data'],['Top Up Game','game'],['Token PLN','pln'],['E-Wallet','ewallet'],['Voucher Digital','voucher']] as [$name,$slug]) Category::firstOrCreate(['slug'=>$slug],['name'=>$name,'status'=>true]); } }
