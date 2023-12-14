<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;

    protected $table = 'app_settings';
    
    protected $fillable = [
        'app_name',
        'icon',
        'non_days',
    ];

    public function getIconAttribute(){
        return $this->attributes['icon'] ? Storage::url($this->attributes['icon']) : ''; 
    }

    public function getNonDaysAttribute(){
        return json_decode($this->attributes['non_days']); 
    }
}
