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

        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->uuid('ad_id')->nullable();
            $table->integer('ad_group_id')->nullable();
            $table->string('ad_name')->nullable();
            $table->string('ad_type')->nullable();
            $table->integer('product_id')->nullable();

            $table->string('ad_url')->nullable();
            $table->string('ad_text')->nullable();
            $table->string('ad_image')->nullable();
            $table->integer('status')->nullable();
            $table->integer('impressions')->nullable();
            $table->integer('clicks')->nullable();
            $table->integer('conversions')->nullable();
            $table->integer('spend')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();   

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
