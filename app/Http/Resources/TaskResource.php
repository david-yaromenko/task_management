<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user_name' => $this->whenLoaded('user', fn() => $this->user->name),
            'task_id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
        ];
    }
}
