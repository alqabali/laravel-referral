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
use Alqabali\Referral\Models\AffiliateReferral;

trait UserReferral
{
    public function getReferralLinkByProgramId($program_id)
    {
        return url('/').'/?ref='.$this->affiliate_id.'&prg='.$program_id;
    }

    public function affiliate_refferals()
    {
        return $this->hasMany(AffiliateReferral::class,'user_id','id');
    }

    public static function scopeReferralExists(Builder $query, $referral)
    {
        return $query->whereAffiliateId($referral)->exists();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($affiliate_id = Cookie::get('affiliate_id') && $affiliateProgramId = Cookie::get('affiliate_program')) {
                $referral_id = AffiliateReferral::create([
                    'affiliate_program_id' => is_numeric($affiliateProgramId) ? $affiliateProgramId : 0,
                    'status' => 'unpaid',
                    'user_id' => self::getUserIdByAffiliateId($affiliate_id)
                ])->id;
                $model->referral_id = $referral_id;
            }

            $model->affiliate_id = self::generateReferral();
        });
    }

    protected static function getUserIdByAffiliateId($affiliate_id){
        return (new self)::first()->id;
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
