<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AcademicSetting extends Model {
    protected $fillable = ['school_year','semester','update_open','update_deadline'];
    protected function casts(): array { return ['update_open'=>'boolean','update_deadline'=>'datetime']; }
}
