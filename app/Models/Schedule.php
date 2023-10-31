<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'schedules';
    
    protected $fillable = [
        'start_time',
        'end_time',
    ];

    protected $dates = ['deleted_at'];

    //SCOPES
    public function scopeSearch($query, $search){ 
        return $query->where('start_time', 'LIKE', "%{$search}%")->where('end_time', 'LIKE', "%{$search}%");
    }
}
