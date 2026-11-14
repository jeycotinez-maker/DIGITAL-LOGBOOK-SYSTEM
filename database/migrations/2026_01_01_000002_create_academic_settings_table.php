<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('academic_settings', function(Blueprint $t) {
  $t->id(); $t->string('school_year',30); $t->string('semester',30); $t->boolean('update_open')->default(false); $t->dateTime('update_deadline')->nullable(); $t->timestamps();
 }); }
 public function down(): void { Schema::dropIfExists('academic_settings'); }
};
