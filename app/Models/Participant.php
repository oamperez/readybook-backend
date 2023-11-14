<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'participants';
    
    protected $fillable = [
        'cui',
        'name',
        'appointment_id',
        'age',
        'gender',
        'country',
    ];

    protected $dates = ['deleted_at'];

    public function appointment(){ return $this->hasMany('App\Models\Appointment'); }
}
