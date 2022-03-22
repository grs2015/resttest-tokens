<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'itemsQty' => $this->order_item_quantity,
            'itemsSum' => $this->order_item_sum,
            'productName' => $this->product->title,
            'productPrice' => $this->product->price,
            'orderNumber' => $this->order->order_number,
            'creationDate' => $this->created_at,
            'lastChangeDate' => $this->updated_at,
            'deletionDate' => $this->deleted_at,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('orderitems.show', $this->id)
                ],
                [
                    'rel' => 'orderitems.products',
                    'href' => route('orderitems.products.index', $this->id)
                ],
                [
                    'rel' => 'orderitems.producers',
                    'href' => route('orderitems.producers.index', $this->id)
                ],
                [
                    'rel' => 'orderitems.categories',
                    'href' => route('orderitems.categories.index', $this->id)
                ],
                [
                    'rel' => 'orderitems.orders',
                    'href' => route('orderitems.orders.index', $this->id)
                ],
                [
                    'rel' => 'orderitems.customers',
                    'href' => route('orderitems.customers.index', $this->id)
                ],
                [
                    'rel' => 'orderitems.regions',
                    'href' => route('orderitems.regions.index', $this->id)
                ],
                [
                    'rel' => 'orderitems.branches',
                    'href' => route('orderitems.branches.index', $this->id)
                ]
            ]
        ];
    }
}
