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
        Schema::create('ar_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('region');
            $table->string('address_line_1');
            $table->string('city');
            $table->string('postcode');
            $table->string('country');
            $table->string('contact_email');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ar_addresses');
    }
};
