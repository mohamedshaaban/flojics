<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,   Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $appends = [
        'profile_picture'
    ];
    protected $fillable = [
        'name', 'email', 'password',
        'first_name',
'last_name',
'phone',
'whatsapp_number',
'file',
 'passport_id',
'dob',
'age',
'civil_id',
'passport',
'profile_picture',
'his_ref',
'otp',
'reset_password_otp',
 'gender',
        'update_phone','update_email','update_profile_picture','update_otp'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getProfilePictureAttribute()
    {
         if(!$this->attributes['profile_picture'])
        {
            return 'profilepic.png';
        }
        return $this->attributes['profile_picture'];
    }
}
