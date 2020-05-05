<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    /**
     * Override standart method for work with queue
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\QueueVerifyEmail);
    }

    public static function manualRegistration($name, $email)
    {
        $newUser = new User;
        $newUser->name = $name;
        $newUser->email = $email;
        $newUser->password = 'nope';
        $date = new \DateTime();
        $newUser->email_verified_at = $date->format('Y-m-d H:i:s');
        $newUser->save();
        return $newUser;
    }
}
