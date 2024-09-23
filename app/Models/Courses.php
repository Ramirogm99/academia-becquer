<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courses extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'courses';
    protected $fillable = ['name', 'course', 'price'];

    public function clients()
    {
        return $this->hasMany(ClientCourse::class , 'course_id');
    }
}
