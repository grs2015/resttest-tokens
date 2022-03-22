<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
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
            'title' => $this->region,
            'slug' => $this->region_short,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('regions.show', $this->id)
                ],
                [
                    'rel' => 'regions.customers',
                    'href' => route('regions.customers.index', $this->id)
                ],
                [
                    'rel' => 'regions.branches',
                    'href' => route('regions.branches.index', $this->id)
                ],
                [
                    'rel' => 'regions.orders',
                    'href' => route('regions.orders.index', $this->id)
                ],
                [
                    'rel' => 'regions.orderitems',
                    'href' => route('regions.orderitems.index', $this->id)
                ],
                [
                    'rel' => 'regions.products',
                    'href' => route('regions.products.index', $this->id)
                ],
                [
                    'rel' => 'regions.producers',
                    'href' => route('regions.producers.index', $this->id)
                ],
                [
                    'rel' => 'regions.categories',
                    'href' => route('regions.categories.index', $this->id)
                ]
            ]
        ];
    }
}
