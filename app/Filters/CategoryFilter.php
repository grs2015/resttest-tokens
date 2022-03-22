<?php

namespace App\Filters;

class CategoryFilter extends QueryFilter {

    public function search($keyword) {
        return $this->builder->where('title', 'like', '%'.$keyword.'%');
    }
}
