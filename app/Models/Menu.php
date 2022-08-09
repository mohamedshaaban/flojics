<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Common;

class Menu extends Model
{
    use SoftDeletes;

    protected $appends = [
        'name'
    ];

    protected $fillable = [
        'name_en', 'name_ar', 'url', 'word_activ', 'in_why_wara', 'in_footer', 'in_header', 'status', 'order'
    ];

    public function getNameAttribute()
    {
        return Common::nameLanguage($this->name_en, $this->name_ar);
    }
}
