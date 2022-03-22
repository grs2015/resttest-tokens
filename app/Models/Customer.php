<?php

namespace App\Models;

use App\Filters\QueryFilter;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\CustomerResource;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\CustomerCollection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Customer
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property int $region_id
 * @property int $branch_id
 * @property int $detail_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch $branch
 * @property-read \App\Models\Detail $detail
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\Region $region
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\CustomerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Customer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|Customer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Customer withoutTrashed()
 * @method static Builder|Customer filter(\App\Filters\QueryFilter $filters)
 */
class Customer extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = [
        'title',
        'region_id',
        'branch_id',
        'detail_id',
        'slug',
    ];

    public $resource = CustomerResource::class;
    public $resourceCollection = CustomerCollection::class;

    public function scopeFilter(Builder $builder, QueryFilter $filters) {
        return $filters->apply($builder);
    }

    protected $with = [
        'branch',
        'detail',
        'region'
    ];

    public function branch() {
        return $this->belongsTo(Branch::class);
    }

    public function detail() {
        return $this->belongsTo(Detail::class);
    }

    public function region() {
        return $this->belongsTo(Region::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

}
