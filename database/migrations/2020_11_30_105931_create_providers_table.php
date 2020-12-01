<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('providers_meta', function (Blueprint $table) {
            $table->id();
            $table->integer('provider_id');
            // $table->string('name');
            $table->string('type');
            $table->text('description');
            $table->string('rule');
            $table->integer('rule_length')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
        Schema::dropIfExists('providers_meta');
    }
}
