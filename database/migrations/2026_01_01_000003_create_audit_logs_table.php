<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('audit_logs', function(Blueprint $t) {
  $t->id(); $t->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); $t->string('action'); $t->string('target_type')->nullable(); $t->unsignedBigInteger('target_id')->nullable(); $t->json('details')->nullable(); $t->string('ip_address',45)->nullable(); $t->timestamps();
 }); }
 public function down(): void { Schema::dropIfExists('audit_logs'); }
};
