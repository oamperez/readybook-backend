<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';
    
    protected $fillable = [
        'name',
    ];

    protected $dates = ['deleted_at'];

    //SCOPES
    public function scopeSearch($query, $search){ 
        return $query->where('name', 'LIKE', "%{$search}%");
    }
}
