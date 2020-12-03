<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Mail extends JsonResource
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
            'data' => [
                'type' => 'mails',
                'id' => $this->id,
                'attributes' => [
                    'title' => $this->title,
                    'recipients' => $this->recipients,
                    'content_type' => $this->content_type,
                    'body' => $this->body,
                ],

            ],
            'links' => [
                'self' => url('/api/mails/' . $this->id),
            ]
        ];
    }
}
