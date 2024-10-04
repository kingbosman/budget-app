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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('costs', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->integer('amount');
            $table->string('category');
            $table->timestamps();
        });

        Schema::create('budget_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_id')->constrained();
            $table->foreignId('user_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget');
        Schema::dropIfExists('cost');
        Schema::dropIfExists('budget_user');
    }
};
