<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Specialty as SpecialtyResource;
 use App\Http\Resources\Language as LanguageResource;
use App\Http\Resources\Publication as PublicationResource;
use DateTime;

class Doctor extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $working_date_calcul = new DateTime($this->working_date);
        $date = new DateTime(date("Y-m-d H:i:s"));
        $interval = $working_date_calcul->diff($date);
        // dump($working_date_calcul);
        // dump(date('Y') );
        // $experience = $interval->format('%y');

        $experience = (int)date('Y') - (int)$this->working_date;
        // dd($exp);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'gender' => $this->gender,
            'picture' => $this->picture,
            'brief' => $this->brief,
            'working_date' => $this->working_date,
            'experience' => $experience,
            'certificates' => $this->certificates,
            'experience_description' => $this->experience_description,
            'education' => $this->education,
            'achievments' => $this->achievments,
            'meta_title' => $this->meta_title,
            'meta_keywords' => $this->meta_keywords,
            'meta_description' => $this->meta_description,
            'department_id' => $this->department_id,
            'specialty' => new SpecialtyResource($this->specialty),
        ];
    }
}
