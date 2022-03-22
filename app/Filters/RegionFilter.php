<?php

namespace App\Filters;

class RegionFilter extends QueryFilter {

    public function region($order = 'asc') {
        return $this->builder->orderBy('region_short', $order);
    }

    public function search($keyword) {
        return $this->builder->where('region_short', 'like', '%'.$keyword.'%');
    }
}
