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

    public function user(){ return $this->belongsTo('App\Models\User')->withTrashed(); }

    public function category(){ return $this->belongsTo('App\Models\Category')->withTrashed(); }

    public function schedule(){ return $this->belongsTo('App\Models\Schedule')->withTrashed(); }

    public function participants(){ return $this->hasMany('App\Models\Participant')->withTrashed(); }
}
