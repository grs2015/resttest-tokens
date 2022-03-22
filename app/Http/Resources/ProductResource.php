<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'productName' => $this->title,
            'productDescription' => $this->description,
            'productStatus' => $this->status,
            'productPrice' => $this->price,
            'productImage' => $this->image,
            'productSlug' => $this->slug,
            'producer' => $this->producer->title,
            'creationDate' => $this->created_at,
            'lastChangeDate' => $this->updated_at,
            'deletionDate' => $this->deleted_at,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('products.show', $this->id)
                ],
                [
                    'rel' => 'products.customers',
                    'href' => route('products.customers.index', $this->id)
                ],
                [
                    'rel' => 'products.producers',
                    'href' => route('products.producers.index', $this->id)
                ],
                [
                    'rel' => 'products.orderitems',
                    'href' => route('products.orderitems.index', $this->id)
                ],
                [
                    'rel' => 'products.orders',
                    'href' => route('products.orders.index', $this->id)
                ],
                [
                    'rel' => 'products.branches',
                    'href' => route('products.branches.index', $this->id)
                ],
                [
                    'rel' => 'products.regions',
                    'href' => route('products.regions.index', $this->id)
                ],
                [
                    'rel' => 'products.categories',
                    'href' => route('products.categories.index', $this->id)
                ]
            ]
        ];
    }
}
