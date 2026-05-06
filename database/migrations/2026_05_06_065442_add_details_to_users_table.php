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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nickname')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('state_country')->nullable();
            $table->string('occupation')->nullable();
            $table->string('profile_photo')->nullable();
            $table->text('biography')->nullable();
            $table->year('year_admitted')->nullable();
            $table->year('year_graduated')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->boolean('is_active')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nickname', 'gender', 'phone_number', 'state_country', 'occupation',
                'profile_photo', 'biography', 'year_admitted', 'year_graduated', 'is_paid', 'is_active'
            ]);
        });
    }
};
