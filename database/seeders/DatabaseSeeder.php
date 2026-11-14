<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder {
 public function run(): void {
  foreach ([
   ['name'=>'Demo Administrator','email'=>'admin@smartlog.local','password'=>Hash::make('Admin12345!'),'role'=>'admin'],
   ['name'=>'Demo Social Worker','email'=>'staff@smartlog.local','password'=>Hash::make('Staff12345!'),'role'=>'staff'],
   ['name'=>'Juan Dela Cruz','email'=>'student@smartlog.local','password'=>Hash::make('Student12345!'),'role'=>'student','pn_id'=>'202801','batch_year'=>'2028','block_section'=>'A','school_year'=>'2026-2027','semester'=>'1st Semester']
  ] as $user) User::updateOrCreate(['email'=>$user['email']],$user);
 }
}
