<?php

namespace Alqabali\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateProgram extends Model
{
    public function refferals()
    {
        return $this->hasMany(AffiliateRefferal::class,'affiliate_program_id','id');
    }
}

