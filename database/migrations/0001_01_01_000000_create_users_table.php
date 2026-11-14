<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('users', function(Blueprint $t) {
  $t->id(); $t->string('name'); $t->string('email')->unique(); $t->timestamp('email_verified_at')->nullable(); $t->string('password');
  $t->enum('role',['student','staff','admin'])->default('student'); $t->string('pn_id',6)->nullable()->unique();
  $t->string('batch_year',4)->nullable()->index(); $t->string('block_section',40)->nullable(); $t->string('school_year',30)->nullable(); $t->string('semester',30)->nullable(); $t->string('gender',30)->nullable();
  $t->rememberToken(); $t->timestamps();
 }); }
 public function down(): void { Schema::dropIfExists('users'); }
};
