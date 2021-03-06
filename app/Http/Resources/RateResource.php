<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'project_category_id' => $this->project_category_id,
            'project_category' => $this->projectCategory,
            'criterias' => CriteriaResource::collection($this->criterias)
        ];
    }
}
