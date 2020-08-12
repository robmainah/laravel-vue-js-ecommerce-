<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $table = "admins";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeGenerateEmployeeNumber($query)
    {
        $random_id = rand(111111, 999999);
        $value = $query->where('userId', $random_id)->get();
        // $value = count($value);
        if (count($value) > 0) {
            return Self::generateEmployeeNumber();
        }

        return $random_id;
    }

    public function scopeGenerateEmployeePassword()
    {
        $string = str_random(8);
        // $string = "123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvxyz";
        // $length = 8;
        // return substr(str_shuffle($string), 0, $length);

        return $string;
    }

    // public function category()
    // {
    //     return $this->hasMany('App\Category');
    // }

    // public function product()
    // {
    //     return $this->hasMany('App\Product');
    // }

}