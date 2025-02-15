<?php

/*
 * This file is part of questocat/laravel-referral package.
 *
 * (c) questocat <zhengchaopu@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Alqabali\Referral;

use Illuminate\Support\ServiceProvider;

class ReferralServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->setupConfig();
        $this->setupMigrations();
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
    }

    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../config/referral.php');

        $this->publishes([
            $source => config_path('referral.php'),
        ], 'config');

        $this->mergeConfigFrom($source, 'referral');
    }

    /**
     * Setup the migrations.
     */
    protected function setupMigrations()
    {
        $timestamp = date('Y_m_d_His');

        $this->publishes([
            realpath(__DIR__.'/../database/migrations/add_referral_to_users_table.php') => database_path("/migrations/{$timestamp}_add_referral_to_users_table.php"),
            realpath(__DIR__.'/../database/migrations/create_affiliate_programs_table.php') => database_path("/migrations/{$timestamp}_create_affiliate_programs_table.php"),
            realpath(__DIR__.'/../database/migrations/create_affiliate_referrals_table.php') => database_path("/migrations/{$timestamp}_create_affiliate_referrals_table.php"),
        ], 'migrations');
    }
}
