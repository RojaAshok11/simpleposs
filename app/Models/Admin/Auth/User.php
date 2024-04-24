<?php

namespace App\Models\Admin\Auth;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Admin\Auth\Deviceinfo;
use App\Models\Admin\Auth\User;
use App\Models\Commontraits\AuthTraits\HasAuthTrait;
use App\Models\Miscellaneous\Uniqidhelper;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    use HasAuthTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'role_id',
        'note',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function boot(): void
    {
        parent::boot();

        self::creating(function ($model) {
            $model->api_token = Str::random(40);
            Uniqidhelper::autogenerateid(7, 'A', $model);
        });

        self::updating(function ($model) {
            $model->updated_id = auth()->user() ? auth()->id() : 1;
        });

    }

    public function createdby(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function updatedby(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_id');
    }

    public function deviceinfo(): BelongsTo
    {
        return $this->belongsTo(Deviceinfo::class);
    }
}
