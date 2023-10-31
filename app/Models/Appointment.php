<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'appointments';
    
    protected $fillable = [
        'user_id',
        'category_id',
        'date',
        'schedule_id',
        'notify',
        'detail',
        'state',
        'reazon',
    ];

    protected $dates = ['deleted_at'];

    public function user(){ return $this->belongsTo('App\Models\User'); }

    public function category(){ return $this->belongsTo('App\Models\Category'); }

    public function schedule(){ return $this->belongsTo('App\Models\Schedule'); }
}
