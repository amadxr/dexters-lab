<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
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
            'experiment_id' => $this->experiment_id,
            'leads_count' => $this->leads_count,
            'won_opportunities_count' => $this->won_opportunities_count,
            'won_opportunities_annual_value' => $this->won_opportunities_annual_value,
            'open_opportunities_count' => $this->open_opportunities_count,
            'open_opportunities_annual_value' => $this->open_opportunities_annual_value,
            'created_at' => $this->created_at->format('d M Y'),
            'updated_at' => $this->updated_at->diffForHumans()
        ];
    }
}
