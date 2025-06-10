<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->uuid('campaign_id')->nullable();
            $table->integer('seller_id')->nullable();
            $table->string('campaign_name')->nullable();
            $table->integer('status')->nullable();
            
            $table->integer('total_budget')->nullable();
            $table->integer('daily_budget')->nullable();
            $table->integer('total_impressions')->nullable();
            $table->integer('total_clicks')->nullable();
            $table->integer('total_conversions')->nullable();
            $table->integer('total_spend')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
