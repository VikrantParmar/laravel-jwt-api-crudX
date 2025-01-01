<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject; // Import the JWTSubject interface

class User extends Authenticatable implements JWTSubject // Implement the interface
{
    use Notifiable, SoftDeletes;
    const DEFAULT_IMAGE = '100_no_img.jpg';
    // Specify which attributes are mass assignable
    protected $fillable = [
        'unique_id',
        'verification_code',
        'first_name',
        'last_name',
        'email',
        'password',
        'profile_image',
        'phone_number',
        'role_id',
        'status',
    ];

    // Specify which attributes should be hidden for arrays
    protected $hidden = [
        'password', 'verification_code'
    ];

    // Specify whether the model should use timestamps
    public $timestamps = true;

    protected $casts = [
      //  'status' => UserStatus::class, // Cast status field to Userstatus Enum
    ];
    protected $appends = ['status_name', 'profile_image_url'];

    // Accessor for full name
    public function getFullNameAttribute()
    {
        return ucwords($this->first_name . ' ' . $this->last_name);
    }

    // Mutator for password to ensure it's hashed before saving
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
    // Query scope to get non-deleted users
    public function scopeNotDeleted($query)
    {
        return $query->where('status', '<>', UserStatus::Deleted);
    }
    // Query scope to get All Admin User List
    public function scopeGetAdminOnly($query)
    {
        return $query->where('role_id', 1);
    }

    // Accessor for profile image URL
    public function getProfileImageUrlAttribute()
    {
        // Get default image URL
        $default = \Storage::disk('default')->url(self::DEFAULT_IMAGE);
        // Check if profile image is set, otherwise use the default
        $profileImage = $this->profile_image ? \Storage::disk('user')->url($this->profile_image) : $default;
        return (object)[
            'original' => $profileImage,
            'default' => $default
        ];
    }

    public function getStatusNameAttribute()
    {
        $statuses = UserStatus::getValues();
        return $statuses[$this->status] ?? 'Unknown';
    }

    // Implementing JWTSubject methods
    public function getJWTIdentifier()
    {
        // This should return the primary key of the user
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        // You can customize claims here, but for now, return an empty array
        return [];
    }

    protected static function boot()
    {
        parent::boot();
        // Automatically generate a unique ID when creating a new user
        static::creating(function ($user) {
            $user->unique_id = $user->unique_id ?: 'VXC' . \Str::padLeft(User::max('id') + 1, 3, '0');
        });
    }
}
