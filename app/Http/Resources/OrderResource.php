<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'orderNumber' => $this->order_number,
            'orderDate' => $this->order_date,
            'orderItems' => $this->orderitems_count,
            'orderSum' => $this->order_sum,
            'customerName' => CustomerResource::make($this->whenLoaded('customer')),
            'creationDate' => $this->created_at,
            'lastChangeDate' => $this->update_at,
            'deletionDate' => $this->deleted_at,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('orders.show', $this->id)
                ],
                [
                    'rel' => 'orders.customers',
                    'href' => route('orders.customers.index', $this->id)
                ],
                [
                    'rel' => 'orders.branches',
                    'href' => route('orders.branches.index', $this->id)
                ],
                [
                    'rel' => 'orders.regions',
                    'href' => route('orders.regions.index', $this->id)
                ],
                [
                    'rel' => 'orders.orderitems',
                    'href' => route('orders.orderitems.index', $this->id)
                ],
                [
                    'rel' => 'orders.products',
                    'href' => route('orders.products.index', $this->id)
                ],
                [
                    'rel' => 'orders.producers',
                    'href' => route('orders.producers.index', $this->id)
                ],
                [
                    'rel' => 'orders.categories',
                    'href' => route('orders.categories.index', $this->id)
                ],
                [
                    'rel' => 'orders.users',
                    'href' => route('orders.users.index', $this->id)
                ]
            ]

        ];
    }
}
