<?php

namespace App\Models;

use App\Models\Client;
use App\Services\GenerateAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    // role labels
    public const ROLE_LABELS = [
        'admin' => '総合管理者',
        'manager' => '管理者',
        'staff' => 'スタッフ',
        'external' => '外部スタッフ',
        'back_office' => 'バックオフィス',
        'client' => 'クライアント',
    ];

    /**
     * The "booting" method of the model.
     * 
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->{$user->getKeyName()})) {
                $user->{$user->getKeyName()} = Str::uuid()->toString();
            }
            // if (empty($user->avatar)) {
            //     $user->avatar = '/storage/avatars/' . (new GenerateAvatar())->generate($user->name);
            // }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'organisation_id',
        'name',
        'nickname',
        'email',
        'password',
        'avatar',
        'message',
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

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function getAvatarAttribute($value)
    {
        return $value ?? 'img/default-avatar.png';
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_staff', 'staff_id', 'client_id')->using(ClientStaff::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class,'id');
    }

    public function getDisplayNameAttribute()
    {

        $fullname = $this->name;
        $orgName = $this->organisation->name;

        $displayName = "{$fullname} ({$orgName})";

        return $displayName;
    }
}
