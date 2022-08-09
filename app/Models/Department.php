<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Common;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Department extends Model
{
    use SoftDeletes;

    protected $appends = [
        'name', 'short_description', 'description', 'description_strip', 'desc_image', 'desc_video', 'meta_title',
        'meta_keywords', 'meta_description'
    ];

    protected $fillable = [
        'name_en', 'name_ar','slug', 'short_description_en', 'short_description_ar','description_en', 'description_ar',
        'desc_image_en', 'desc_image_ar', 'desc_video_en', 'desc_video_ar', 'image', 'phone', 'status', 'in_home',
        'meta_title_en' , 'meta_title_ar', 'meta_keywords_en', 'meta_keywords_ar',
        'meta_description_en', 'meta_description_ar','his_ref','show_appt'
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    protected static function boot()
    {
        parent::boot();
        $locale = app()->getLocale();
        if ($locale == 'en') {
            static::addGlobalScope('name_en', function (Builder $builder) {
                $builder->orderBy('name_en', 'ASC');
            });
        }else{
            static::addGlobalScope('name_ar', function (Builder $builder) {
                $builder->orderBy('name_ar', 'ASC');
            });
        }
    }

    public function getNameAttribute()
    {
        return Common::nameLanguage($this->name_en, $this->name_ar);
    }

    public function getShortDescriptionAttribute()
    {
        return Common::nameLanguage($this->short_description_en, $this->short_description_ar);
    }

    public function getDescriptionAttribute()
    {
        return Common::nameLanguage($this->description_en, $this->description_ar);
    }

    public function getDescriptionStripAttribute(){
        return Str::limit(strip_tags($this->description), 300);
    }

    public function getDescImageAttribute()
    {
        return Common::nameLanguage($this->desc_image_en, $this->desc_image_ar);
    }

    public function getDescVideoAttribute()
    {
        return Common::nameLanguage($this->desc_video_en, $this->desc_video_ar);
    }

    public function getMetaTitleAttribute()
    {
        return Common::nameLanguage($this->meta_title_en, $this->meta_title_ar);
    }

    public function getMetaKeywordsAttribute()
    {
        return Common::nameLanguage($this->meta_keywords_en, $this->meta_keywords_ar);
    }

    public function getMetaDescriptionAttribute()
    {
        return Common::nameLanguage($this->meta_description_en, $this->meta_description_ar);
    }

}
