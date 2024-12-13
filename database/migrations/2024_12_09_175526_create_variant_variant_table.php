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
        Schema::create('variant_variant', function (Blueprint $table) {
            $table->id();

            $table->foreignId('selected_variant_id')->constrained('variants');
            $table->foreignId('affected_variant_id')->constrained('variants');

            $table->integer('affected_price_amount_increase')->nullable();
            $table->boolean('affected_disabled')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
