<?php

namespace App\Models;

use App\Models\Customer;
use App\Http\Resources\DetailResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Detail
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Detail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Detail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Detail query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $description
 * @property string $image
 * @property string $phone
 * @property string $email
 * @property string $website
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Customer|null $customer
 * @method static \Database\Factories\DetailFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Detail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Detail whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Detail whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Detail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Detail whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Detail wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Detail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Detail whereWebsite($value)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Detail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Detail whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Detail withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Detail withoutTrashed()
 */
class Detail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'image',
        'phone',
        'email',
        'website'
    ];

    public $resource = DetailResource::class;

    public function customer() {
        return $this->hasOne(Customer::class);
    }

    // public function getWebsiteAttribute($website) {
    //     return "www." . $website;
    // }

    public function setWebsiteAttribute($website) {
        $this->attributes['website'] = strtolower($website);
    }

    public function setEmailAttribute($email) {
        $this->attributes['email'] = strtolower($email);
    }


}
