<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payments extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'payments';
    protected $fillable = ['course_client_id', 'paid'];

    public function courseClient()
    {
        return $this->belongsTo(ClientCourse::class, 'course_client_id');
    }
}
