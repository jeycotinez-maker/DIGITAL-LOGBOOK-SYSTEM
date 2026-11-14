<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('attendances', function(Blueprint $t) {
  $t->id(); $t->foreignId('student_id')->constrained('users')->cascadeOnDelete(); $t->date('date')->index();
  $t->dateTime('time_in'); $t->dateTime('time_out')->nullable(); $t->enum('status',['inside','outside'])->default('inside');
  $t->foreignId('time_in_by')->nullable()->constrained('users')->nullOnDelete(); $t->foreignId('time_out_by')->nullable()->constrained('users')->nullOnDelete();
  $t->string('remarks',250)->nullable(); $t->timestamps(); $t->index(['student_id','date']);
 }); }
 public function down(): void { Schema::dropIfExists('attendances'); }
};
