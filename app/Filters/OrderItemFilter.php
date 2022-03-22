<?php

namespace App\Filters;

class OrderItemFilter extends QueryFilter {

    public function item_sum($value = 'asc') {
        return $this->builder->orderBy('order_item_sum', $value);
    }

    public function products($productIds) {
        return $this->builder->whereIn('product_id', $this->paramToArray($productIds));
    }

    public function order($orderId) {
        return $this->builder->where('order_id', $orderId);
    }
}
