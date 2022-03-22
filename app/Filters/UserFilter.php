<?php

namespace App\Filters;

class UserFilter extends QueryFilter {

    public function first_name($order = 'asc') {
        return $this->builder->orderBy('first_name', $order);
    }

    public function last_name($order = 'asc') {
        return $this->builder->orderBy('last_name', $order);
    }

    public function search($keyword) {
        return $this->builder->where('first_name', 'like', '%'.$keyword.'%')
            ->orWhere('last_name', 'like', '%'.$keyword.'%');
    }

    public function verified($status = 0) {
        return $this->builder->where('verified', $status);
    }

    public function role($status = 0) {
        return $this->builder->where('purchase_role', $status);
    }

    public function customer($id) {
        return $this->builder->where('customer_id', $id);
    }
}
