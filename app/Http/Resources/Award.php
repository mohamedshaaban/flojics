<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DateTime;

class Award extends JsonResource
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
            'image' => $this->image,
            'description' => $this->description,
            'desc_image' => $this->desc_image,
            'desc_video' => $this->desc_video,
            'date' => date_format( $date, 'jS M Y'),
        ];
    }
}
