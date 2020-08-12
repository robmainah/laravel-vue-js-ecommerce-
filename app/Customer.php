<?php

namespace App;

use App\Notifications\RegisterCustomerNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Customer extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    // protected $table = "customers";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'idNumber', 'customerId', 'phone_number', 'address', 'gender', 'email_verified_at',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function orderTrack()
    {
        return $this->morphMany('App\OrderTrack', 'orderable');
    }

    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public function scopeGenerateCustomerNumber($query)
    {
        $random_id = rand(111111111, 999999999);
        $value = $query->where('customerId', $random_id)->get();

        if (count($value) > 0) {
            return Self::generateCustomerNumber();
        }

        return $random_id;
    }

    public function sendRegisterCustomerNotification()
    {
        $this->notify(new RegisterCustomerNotification($this));
    }

    /* public function getCreatedByAttribute($value)
    {
        return Customer::where('id', $value)->first();
    } */
}