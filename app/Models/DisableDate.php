<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DisableDate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'disable_dates';
    
    protected $fillable = [
        'date',
    ];

    protected $dates = ['deleted_at'];

    //SCOPES
    public function scopeSearch($query, $search){ 
        return $query->where('date', 'LIKE', "%{$search}%");
    }
}
