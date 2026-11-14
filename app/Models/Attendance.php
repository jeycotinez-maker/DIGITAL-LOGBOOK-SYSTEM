<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Attendance extends Model {
    protected $fillable = ['student_id','date','time_in','time_out','status','time_in_by','time_out_by','remarks'];
    protected function casts(): array { return ['date'=>'date','time_in'=>'datetime','time_out'=>'datetime']; }
    public function student(): BelongsTo { return $this->belongsTo(User::class, 'student_id'); }
    public function encoder(): BelongsTo { return $this->belongsTo(User::class, 'time_in_by'); }
}
