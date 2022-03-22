<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'slug' => $this->slug,
            'customer_region' => $this->region, //NOTE - Это не связь, а поле полученное через JOIN в Builder в CustomerFilter
            'customer_branch' => $this->branch, //NOTE - Это не связь, а поле полученное через JOIN в Builder в CustomerFilter
            'customer_detail' => DetailResource::make($this->detail),
            'creationDate' => $this->created_at,
            'lastChangeDate' => $this->updated_at,
            'deletionDate' => $this->deleted_at,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('customers.show', $this->id)
                ],
                [
                    'rel' => 'customers.categories',
                    'href' => route('customers.categories.index', $this->id)
                ],
                [
                    'rel' => 'customers.branches',
                    'href' => route('customers.branches.index', $this->id)
                ],
                [
                    'rel' => 'customers.regions',
                    'href' => route('customers.regions.index', $this->id)
                ],
                [
                    'rel' => 'customers.orderitems',
                    'href' => route('customers.orderitems.index', $this->id)
                ],
                [
                    'rel' => 'customers.products',
                    'href' => route('customers.products.index', $this->id)
                ],
                [
                    'rel' => 'customers.producers',
                    'href' => route('customers.producers.index', $this->id)
                ],
                [
                    'rel' => 'customers.orders',
                    'href' => route('customers.orders.index', $this->id)
                ],
                [
                    'rel' => 'customers.users',
                    'href' => route('customers.users.index', $this->id)
                ],
            ]
        ];
    }
}
