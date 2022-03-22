<?php

namespace App\Models;

use App\Models\OrderItem;
use App\Filters\QueryFilter;
use Laravel\Scout\Searchable;
use App\Http\Resources\ProductResource;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\ProductCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Product
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $status
 * @property string $image
 * @property string $price
 * @property int $producer_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|OrderItem[] $order_items
 * @property-read int|null $order_items_count
 * @property-read \App\Models\Producer $producer
 * @method static \Database\Factories\ProductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProducerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 * @method static Builder|Product filter(\App\Filters\QueryFilter $filters)
 */
class Product extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    const AVAILABLE_PRODUCT = 'available';
    const UNAVAILABLE_PRODUCT = 'unavailable';

    protected $fillable = [
        'title',
        'description',
        'status',
        'image',
        'price',
        'producer_id',
        'slug'
    ];

    // protected $with = [
    //     'producer'
    // ];

    protected $hidden = [
        'pivot'
    ];

    public $resource = ProductResource::class;
    public $resourceCollection = ProductCollection::class;

    public function scopeFilter(Builder $builder, QueryFilter $filters) {
        return $filters->apply($builder);
    }

    public function isAvailable() {
        return $this->status = Product::AVAILABLE_PRODUCT;
    }

    public function order_items() {
        return $this->hasMany(OrderItem::class);
    }

    public function producer() {
        return $this->belongsTo(Producer::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }
}
