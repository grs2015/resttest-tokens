<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class CustomerFilter extends QueryFilter {

    public function title($order = 'asc') {
        return $this->builder->orderBy('title', $order);
    }

    public function region($order = 'asc') {
        return $this->builder->orderBy('region_id', $order);
    }

    public function branch($order = 'asc') {
        return $this->builder->orderBy('branch_id', $order);
    }

    public function search($keyword) {
        return $this->builder
            ->where('title', 'like', '%'.$keyword.'%')
            ->orWhere('region', 'like', '%'.$keyword.'%')
            ->orWhere('branch', 'like', '%'.$keyword.'%');
    }

    // NOTE - Закомментировано, так как поиск в связанных таблицах делается по id (внешнему ключу),
    // а не по содержанию строк в этих таблицах

    // public function branch($keyword) {
    //     return $this->builder->whereHas('branch', function(Builder $query) use ($keyword) {
    //         $query->where('branch_short', 'like', '%'.$keyword.'%');
    //     });
    // }

    // public function region($keyword) {
    //     return $this->builder->whereHas('region', function(Builder $query) use ($keyword) {
    //         $query->where('region_short', 'like', '%'.$keyword.'%');
    //     });
    // }

    public function branches($branchIds) {
        return $this->builder->whereIn('branch_id', $this->paramToArray($branchIds));
    }

    public function regions($regionIds) {
        return $this->builder->whereIn('region_id', $this->paramToArray($regionIds));
    }

}
