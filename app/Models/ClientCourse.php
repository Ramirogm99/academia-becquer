<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientCourse extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'course_client';
    protected $fillable = ['client_id', 'course_id', 'total', 'hours'];

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }
    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }
    public function payments()
    {
        return $this->hasMany(Payments::class, 'course_client_id');
    }
}
