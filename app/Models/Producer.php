<?php

namespace App\Models;

use App\Filters\QueryFilter;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\ProducerResource;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\ProducerCollection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Producer
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Producer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Producer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Producer query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $image_logo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\ProducerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Producer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producer whereImageLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producer whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producer whereUpdatedAt($value)
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static Builder|Producer filter(\App\Filters\QueryFilter $filters)
 * @method static \Illuminate\Database\Query\Builder|Producer onlyTrashed()
 * @method static Builder|Producer whereDeletedAt($value)
 * @method static Builder|Producer whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|Producer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Producer withoutTrashed()
 */
class Producer extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    const PRODUCER_SUFFIXES = ['ltd', 'gmbh'];

    protected $fillable = [
        'title',
        'description',
        'image_logo',
        'slug'
    ];

    public $resource = ProducerResource::class;
    public $resourceCollection = ProducerCollection::class;

    public function scopeFilter(Builder $builder, QueryFilter $filters) {
        return $filters->apply($builder);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
}
