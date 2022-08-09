<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DateTime;

class Activity extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $date = new DateTime($this->date);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'desc_image' => $this->desc_image,
            'desc_video' => $this->desc_video,
            'image' => $this->image,
            'date' => date_format( $date, 'M d Y'),
        ];
    }
}
