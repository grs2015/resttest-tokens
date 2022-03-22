<?php

namespace App\Models;

use App\Models\Customer;
use App\Filters\QueryFilter;
use Laravel\Scout\Searchable;
use App\Http\Resources\RegionResource;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\RegionCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Region
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $region
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\RegionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereUpdatedAt($value)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Customer[] $customers
 * @property-read int|null $customers_count
 * @method static \Illuminate\Database\Query\Builder|Region onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Region withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Region withoutTrashed()
 * @property string $region_short
 * @method static Builder|Region filter(\App\Filters\QueryFilter $filters)
 * @method static Builder|Region whereRegionShort($value)
 */
class Region extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = [
        'region',
        'region_short'
    ];

    public $resource = RegionResource::class;
    public $resourceCollection = RegionCollection::class;

    public function scopeFilter(Builder $builder, QueryFilter $filters) {
        return $filters->apply($builder);
    }

    public function customers() {
        return $this->hasMany(Customer::class);
    }
}
