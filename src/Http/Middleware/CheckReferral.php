<?php

/*
 * This file is part of questocat/laravel-referral package.
 *
 * (c) questocat <zhengchaopu@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Alqabali\Referral\Http\Middleware;
use Illuminate\Support\Facades\Cookie;

use Closure;

class CheckReferral
{
    public function handle($request, Closure $next)
    {
        if ($request->hasCookie('affiliate_id') && $request->hasCookie('affiliate_program')) {
            return $next($request);
        }

        if (($ref = $request->query('ref')) && ($prg = $request->query('prg')) && app(config('referral.user_model', 'App\User'))->referralExists($ref)) {
            Cookie::queue('affiliate_id', $ref, 1999999999);
            Cookie::queue('affiliate_program', $prg, 1999999999);
        }

        return $next($request);
    }
}
