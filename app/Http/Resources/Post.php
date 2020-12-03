<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{

    public function toArray($request)
    {
        return [
            'data' => [
                'type' => 'posts',
                'id' => $this->id,
                'attributes' => [
                    'title' => $this->title,
                    'body' => $this->body,
                ],

            ],
            'links' => [
                'self' => url('/api/posts/' . $this->id),
            ]
        ];
    }
}
