<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'catName' => $this->title,
            'catDescription' => $this->description,
            'catSlug' => $this->slug,
            'creationDate' => $this->created_at,
            'lastChangeDate' => $this->updated_at,
            'deletionDate' => $this->deleted_at,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('categories.show', $this->id)
                ],
                [
                    'rel' => 'categories.products',
                    'href' => route('categories.products.index', $this->id)
                ],
                [
                    'rel' => 'categories.producers',
                    'href' => route('categories.producers.index', $this->id)
                ],
                [
                    'rel' => 'categories.orderitems',
                    'href' => route('categories.orderitems.index', $this->id)
                ],
                [
                    'rel' => 'categories.orders',
                    'href' => route('categories.orders.index', $this->id)
                ],
                [
                    'rel' => 'categories.customers',
                    'href' => route('categories.customers.index', $this->id)
                ],
                [
                    'rel' => 'categories.branches',
                    'href' => route('categories.branches.index', $this->id)
                ],
                [
                    'rel' => 'categories.regions',
                    'href' => route('categories.regions.index', $this->id)
                ],
            ]
        ];
    }
}
