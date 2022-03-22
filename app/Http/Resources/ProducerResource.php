<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProducerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'identifier' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'image' => $this->image_logo,
            'creationDate' => $this->created_at,
            'lastChangeDate' => $this->updated_at,
            'deletionDate' => isset($this->deleted_at) ? $this->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('producers.show', $this->id)
                ],
                [
                    'rel' => 'producers.categories',
                    'href' => route('producers.categories.index', $this->id)
                ],
                [
                    'rel' => 'producers.orderitems',
                    'href' => route('producers.orderitems.index', $this->id)
                ],
                [
                    'rel' => 'producers.orders',
                    'href' => route('producers.orders.index', $this->id)
                ],
                [
                    'rel' => 'producers.customers',
                    'href' => route('producers.customers.index', $this->id)
                ],
                [
                    'rel' => 'producers.products',
                    'href' => route('producers.products.index', $this->id)
                ]
            ]
        ];
    }
}
