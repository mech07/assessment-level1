<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'prefixname',
        'firstname',
        'middlename',
        'lastname',
        'suffixname',
        'username',
        'email',
        'password',
        'type',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    protected $dates = ['deleted_at'];  // Include deleted_at field

    public function getAvatarAttribute(): string
    {
        // Check if the user has a photo (this assumes you store the avatar URL or file path in a 'photo' column)
        if ($this->photo) {
            return asset('storage/' . $this->photo); // Returns the full URL to the avatar
        }

        // If no avatar is found, return a default image
        return asset('images/default-avatar.png'); // Ensure you have a default image in this path
    }

    public function getFullnameAttribute(): string
    {
        // Check if the middlename exists and append it
        return trim($this->firstname . ' ' . ($this->middlename ? $this->middlename . ' ' : '') . $this->lastname);
    }

    public function getMiddleinitialAttribute(): ?string
    {

        $middleName = $this->middlename ?? null;

        // Return the first character of the middle name, or null if middlename is not set
        return $middleName ? strtoupper($middleName[0]) : null;
    }
}
