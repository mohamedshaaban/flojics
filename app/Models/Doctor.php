<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Common;
use App\Models\Department;
use App\Models\Specialty;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use SoftDeletes;

    protected $appends = [
        'prefix', 'name', 'brief', 'brief_strip', 'certificates', 'experience_description', 'education', 'achievments', 'meta_title',
        'meta_keywords', 'meta_description'
    ];

    protected $fillable = [
        'prefix_en', 'prefix_ar', 'name_en', 'name_ar','slug', 'gender', 'picture', 'brief_en', 'brief_ar', 'working_date', 'status',
        'experience_description_en', 'experience_description_ar', 'education_en', 'education_ar', 'achievments_en',
        'achievments_ar', 'certificates_en', 'certificates_ar','in_home', 'meta_title_en' , 'meta_title_ar', 'meta_keywords_en',
        'meta_keywords_ar', 'meta_description_en', 'meta_description_ar','his_ref','show_appt'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class,'department_id');
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }


    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    public function tours()
    {
        return $this->belongsToMany(Tour::class);
    }

    public function getPrefixAttribute()
    {
        return Common::nameLanguage($this->prefix_en, $this->prefix_ar);
    }

    public function getNameAttribute()
    {
        return $this->prefix ." ".Common::nameLanguage($this->name_en, $this->name_ar);
    }

    public function getBriefAttribute()
    {
        return Common::nameLanguage($this->brief_en, $this->brief_ar);
    }

    public function getBriefStripAttribute(){
        return Str::limit(strip_tags($this->brief), 300);
    }

    public function getCertificatesAttribute()
    {
        return Common::nameLanguage($this->certificates_en, $this->certificates_ar);
    }

    public function getExperienceDescriptionAttribute()
    {
        return Common::nameLanguage($this->experience_description_en, $this->experience_description_ar);
    }

    public function getEducationAttribute()
    {
        return Common::nameLanguage($this->education_en, $this->education_ar);
    }

    public function getAchievmentsAttribute()
    {
        return Common::nameLanguage($this->achievments_en, $this->achievments_ar);
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
