<?php

namespace Alqabali\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateReferral extends Model
{
    public $table = 'affiliatereferrals';
    protected $guarded = ['id'];
    public function user(){
        return $this->belongsTo(config('referral.user_model', 'App\User'));
    }
    public function program()
    {
        return $this->belongsTo(AffiliateProgram::class);
    }
    public static function scopeUnpaid($query)
    {
        return $query->whereStatus('unpaid');
    }
    public static function scopePaid($query)
    {
        return $query->whereStatus('paid');
    }
}
