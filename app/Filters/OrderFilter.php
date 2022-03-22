<?php

namespace App\Filters;

class OrderFilter extends QueryFilter {

    public function order_number($value = 'asc') {
        return $this->builder->orderBy('order_number', $value);
    }

    public function order_sum($value = 'asc') {
        return $this->builder->orderBy('order_sum', $value);
    }

    public function count($items_count = 'asc') {
        return $this->builder->orderBy('orderitems_count', $items_count);
    }

    public function date($order_date = 'asc') {
        return $this->builder->orderBy('order_date', $order_date);
    }

    public function from($from_date) {
        return $this->builder->where('order_date', '>', $from_date);
    }

    public function to($to_date) {
        return $this->builder->where('order_date', '<', $to_date);
    }

    public function search_order($keyword) {
        return $this->builder->where('order_number', 'like', '%'.$keyword.'%');
    }

    public function search_customer($customerId) {
        return $this->builder->where('customer_id', $customerId);
    }
}
