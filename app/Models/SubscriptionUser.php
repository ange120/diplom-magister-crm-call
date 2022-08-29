<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionUser extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $table = 'subscriptions_users';
    protected $fillable = [
        'id_subscription', 'id_user', 'date_start_subscriptions', 'date_end_subscriptions'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'id', 'id_subscription');
    }

    function endDateSubscription()
    {
        if(is_null($this->date_end_subscriptions)){
            $this->date_end_subscriptions = Carbon::now()->getTimestamp();
        }
        if (Carbon::parse($this->date_end_subscriptions)->getTimestamp() < Carbon::now()->getTimestamp()) {
            return false;
        }
        return true;
    }
}
