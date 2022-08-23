<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_manager',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRolesList()
    {
       return Auth::user()->getrolenames()->toArray();
    }

    public function getSubscriptionsInfoName()
    {
        $SubscriptionUser = SubscriptionUser::where('id_user',$this->id)->first();
        if(!is_null($SubscriptionUser)){
            return Subscription::find($SubscriptionUser->id_subscription)->info_name;
        }
     return 'Нет подписки';
    }

    public function getSubscriptions()
    {
        return SubscriptionUser::where('id_user',$this->id)->first();
    }



}
