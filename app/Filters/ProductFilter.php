<?php

namespace App\Filters;

class ProductFilter extends QueryFilter {

    public function price($value = 'asc') {
        return $this->builder->orderBy('price', $value);
    }

    public function status($status = 'available') {
        return $this->builder->where('status', $status);
    }

    public function producer($producerId) {
        return $this->builder->where('producer_id', $producerId);
    }

    public function search($keyword) {
        return $this->builder->where('title', 'like', '%'.$keyword.'%');
    }
}
