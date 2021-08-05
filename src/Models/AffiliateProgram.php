<?php

namespace Alqabali\Referral\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class AffiliateProgram extends Model
{
    public $table = 'affiliateprograms';
    protected $guarded = ['id'];

    public function getReferralLink(){
        return url('/').'/?ref='.Auth::user()->affiliate_id.'&prg='.$this->id;
    }
    public function refferals()
    {
        return $this->hasMany(AffiliateRefferal::class,'affiliate_program_id','id');
    }

}

