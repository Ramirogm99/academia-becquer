<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clients extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'clients';
    protected $fillable = ['name', 'phone', 'tutor', 'course', 'state', 'zip', 'country', 'courses'];

    public function courses()
    {
        return $this->hasMany(ClientCourse::class , 'client_id');
    }
}
