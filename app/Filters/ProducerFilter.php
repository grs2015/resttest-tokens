<?php

namespace App\Filters;

class ProducerFilter extends QueryFilter {

    public function title($order = 'asc') {
        return $this->builder->orderBy('title', $order);
    }

    public function search($keyword) {
        return $this->builder->where('title', 'like', '%'.$keyword.'%');
    }
}
