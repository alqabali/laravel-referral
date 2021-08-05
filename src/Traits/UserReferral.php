<?php

/*
 * This file is part of questocat/laravel-referral package.
 *
 * (c) questocat <zhengchaopu@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Alqabali\Referral\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

trait UserReferral
{
    public function getReferralLinkByProgramId($program_id)
    {
        return url('/').'/?ref='.$this->affiliate_id.'&prg='.$program_id;
    }

    public function refferals()
    {
        return $this->hasMany(Refferal::class,'user_id','id');
    }

    public static function scopeReferralExists(Builder $query, $referral)
    {
        return $query->whereAffiliateId($referral)->exists();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($referralUserId = Cookie::get('referral_id') && $refferalProgramId = Cookie::get('referral_program')) {
                $model->refferals()->create([
                    'affiliate_program_id' => $refferalProgramId,
                    'status' => 'unpaid',
                    'user_id' => self::getUserByReferralId($referralUserId)
                ]);
            }

            $model->affiliate_id = self::generateReferral();
        });
    }

    protected static function getUserByReferralId($ref_id){
        return static::whereReferralId($ref_id)->first();
    }

    protected static function generateReferral()
    {
        $length = config('referral.referral_length', 5);

        do {
            $referral = Str::random($length);
        } while (static::referralExists($referral));

        return $referral;
    }
}
