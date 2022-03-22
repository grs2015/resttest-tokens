<?php

namespace App\Models;

use App\Models\Customer;
use App\Filters\QueryFilter;
use Laravel\Scout\Searchable;
use App\Http\Resources\BranchResource;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\BranchCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Branch
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Branch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $branch
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Customer[] $customers
 * @property-read int|null $customers_count
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereUpdatedAt($value)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Branch onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Branch withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Branch withoutTrashed()
 * @property string $branch_short
 * @method static Builder|Branch filter(\App\Filters\QueryFilter $filters)
 * @method static Builder|Branch whereBranchShort($value)
 */
class Branch extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = [
        'branch',
        'branch_short'
    ];

    public $resource = BranchResource::class;
    public $resourceCollection = BranchCollection::class;

    public function scopeFilter(Builder $builder, QueryFilter $filters) {
        return $filters->apply($builder);
    }

    public function customers() {
        return $this->hasMany(Customer::class);
    }
}
