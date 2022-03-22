<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'fullName' => $this->full_name,
            'email' => $this->email,
            'isVerified' => $this->verified,
            'isAdmin' => $this->admin,
            'purchaseRole' => $this->purchase_role,
            // 'customerName' => CustomerResource::make($this->whenLoaded('customer')),
            'customerId' => $this->customer_id,
            'creationDate' => $this->created_at,
            'lastChangeDate' => $this->update_at,
            'deletionDate' => $this->delete_at,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('users.show', $this->id)
                ],
            ]
        ];
    }
}
