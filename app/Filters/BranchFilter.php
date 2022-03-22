<?php

namespace App\Filters;

class BranchFilter extends QueryFilter {

    public function branch($order = 'asc') {
        return $this->builder->orderBy('branch_short', $order);
    }

    public function search($keyword) {
        return $this->builder->where('branch_short', 'like', '%'.$keyword.'%');
    }
}
