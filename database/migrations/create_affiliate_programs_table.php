<?php

/*
 * This file is part of questocat/laravel-referral package.
 *
 * (c) questocat <zhengchaopu@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('affiliateprograms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',55);
            $table->string('slug',55)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('affiliateprograms');
    }
}
