<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Support\Str;
use App\Filters\QueryFilter;
use App\Mail\UserCreatedMail;
use Laravel\Scout\Searchable;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Config;
use App\Notifications\UserNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $verified
 * @property string|null $verification_token
 * @property string $admin
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVerificationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVerified($value)
 * @mixin \Eloquent
 * @property int $customer_id
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCustomerId($value)
 * @property-read mixed $full_name
 * @property string $purchase_role
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePurchaseRole($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @property-read Customer $customer
 * @method static Builder|User filter(\App\Filters\QueryFilter $filters)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Searchable;

    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';
    const ADMIN_USER = 'true';
    const REGULAR_USER = 'false';
    const PROCUREMENT_USER = '1';
    const NONPROCUREMENT_USER = '0';

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $resource = UserResource::class;
    public $resourceCollection = UserCollection::class;

    public function scopeFilter(Builder $builder, QueryFilter $filters) {
        return $filters->apply($builder);
    }

    public function isVerified() {
        return $this->verified == User::VERIFIED_USER;
    }

    public function isAdmin() {
        return $this->admin == User::ADMIN_USER;
    }

    public static function generateVerificationToken() {
        return Str::random(40);
    }

    public function getEmailForVerification()
    {
        return $this->email;
    }

    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new UserNotification($this));
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getFirstNameAttribute($first_name) {
        return ucfirst($first_name);
    }

    public function getLastNameAttribute($last_name) {
        return ucfirst($last_name);
    }

    //NOTE Можно ссылаться на $this только в "новых" аттрибутах, которых не существует в модели
    // Соответственно в методе не указывается параметры. Если аксессор для существующего свойства,
    // то в методе указывается параметр и работа ведется с ним, без ссылки на $this.
    public function getFullNameAttribute() {
        return "{$this->first_name} {$this->last_name}";
    }

    public function setFirstNameAttribute($first_name) {
        $this->attributes['first_name'] = strtolower($first_name);
    }

    public function setLastNameAttribute($last_name) {
        $this->attributes['last_name'] = strtolower($last_name);
    }

    public function setEmailAttribute($email) {
        $this->attributes['email'] = strtolower($email);
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        unset($array['verified'], $array['admin'], $array['purchase_role']);

        return $array;
    }

}
