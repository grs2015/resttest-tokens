<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            'title' => $this->branch,
            'slug' => $this->branch_short,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('branches.show', $this->id)
                ],
                [
                    'rel' => 'branches.customers',
                    'href' => route('branches.customers.index', $this->id)
                ],
                [
                    'rel' => 'branches.orders',
                    'href' => route('branches.orders.index', $this->id)
                ],
                [
                    'rel' => 'branches.orderitems',
                    'href' => route('branches.orderitems.index', $this->id)
                ],
                [
                    'rel' => 'branches.products',
                    'href' => route('branches.products.index', $this->id)
                ],
                [
                    'rel' => 'branches.producers',
                    'href' => route('branches.producers.index', $this->id)
                ],
                [
                    'rel' => 'branches.categories',
                    'href' => route('branches.categories.index', $this->id)
                ],
                [
                    'rel' => 'branches.regions',
                    'href' => route('branches.regions.index', $this->id)
                ],
            ]
        ];
    }
}
