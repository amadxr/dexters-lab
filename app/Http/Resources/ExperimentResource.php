<?php

namespace App\Http\Resources;

use App\Http\Resources\ExperimentResultResource;
use App\Http\Resources\TagResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperimentResource extends JsonResource
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
            'title' => $this->title,
            'background' => $this->background,
            'falsifiable_hypothesis' => $this->falsifiable_hypothesis,
            'tags' => TagResource::collection($this->tags),
            'results' => new ExperimentResultResource($this->whenLoaded('results')),
            'validated_learning' => $this->validated_learning,
            'next_action' => $this->next_action,
            'parent_id' => $this->parent_id,
            'smart_view_id' => $this->smart_view_id,
            'smart_view_query' => $this->smart_view_query,
            'created_at' => $this->created_at->format('d M Y'),
            'updated_at' => $this->updated_at->diffForHumans()
        ];
    }
}
