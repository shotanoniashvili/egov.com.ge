<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CriteriaResource extends JsonResource
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
            'rate_id' => $this->rate_id,
            'parent_criteria_id' => $this->parent_criteria_id,
            'subcriterias' => CriteriaResource::collection($this->subCriterias),
            'yes_point' => $this->yes_point,
            'no_point' => $this->no_point,
            'is_percentable' => $this->isPercentable,
            'point_type' => $this->getPointType()
        ];
    }
}
