<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Common;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialty extends Model
{
    use SoftDeletes;

    protected $appends = [
        'name'
    ];

    protected $fillable = [
        'name_en', 'name_ar', 'status'
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function getNameAttribute()
    {
        return Common::nameLanguage($this->name_en, $this->name_ar);
    }

}
