<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $casts = $this->getCasts();
        $attributes = parent::toArray($request);
        foreach ($attributes as $key => $value) {
            if (isset($casts[$key])) {
                settype($attributes[$key], $casts[$key]);
            }
        }
        return $attributes;
    }
}
