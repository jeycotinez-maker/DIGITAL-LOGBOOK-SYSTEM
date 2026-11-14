<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
class User extends Authenticatable {
    use HasFactory, Notifiable;
    protected $fillable = ['name','email','password','role','pn_id','batch_year','block_section','school_year','semester','gender'];
    protected $hidden = ['password','remember_token'];
    protected function casts(): array { return ['email_verified_at'=>'datetime','password'=>'hashed']; }
    public function attendances(): HasMany { return $this->hasMany(Attendance::class, 'student_id'); }
    public function isStaff(): bool { return in_array($this->role, ['staff','admin'], true); }
}
