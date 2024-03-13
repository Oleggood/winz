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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_id')->constrained('travels')->cascadeOnDelete();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->integer('transfer')->nullable();
            $table->text('description')->nullable();
            $table->integer('draft');
            $table->integer('notifications_sent')->nullable();
            $table->text('payment_requirements')->nullable();
            $table->string('currency')->nullable();
            $table->integer('payment')->nullable();
            $table->text('other_requirements')->nullable();
            $table->text('equipment_requirements')->nullable();
            $table->text('transport_requirements')->nullable();
            $table->integer('min_preparation')->nullable(); //подготовка
            $table->integer('accommodations')->nullable(); //условия проживания
            $table->integer('lodging')->nullable(); //ночлег
            $table->integer('escort')->nullable();
            $table->integer('food')->nullable();
            $table->integer('equipment')->nullable();
            $table->integer('passenger')->nullable();
            $table->integer('min_team')->nullable();
            $table->integer('opt_team')->nullable();
            $table->integer('max_team')->nullable();
            $table->integer('fixed_team')->nullable();
            $table->integer('teams')->nullable();
            $table->integer('min_participant')->nullable();
            $table->integer('opt_participant')->nullable();
            $table->integer('max_participant')->nullable();
            $table->integer('transport_provided')->nullable();
            $table->integer('difficult')->nullable();
            $table->datetime('end')->nullable();
            $table->string('timezone')->nullable();
            $table->datetime('start')->nullable();
            $table->string('secret')->nullable();
            $table->integer('features')->nullable();
            $table->integer('type')->nullable();
            $table->string('name')->nullable();
            $table->timestamps();

            $table->integer('status')->default(1);

            $table->integer('length_count')->nullable()->default(1);

            /* Связанные таблицы:
             * цель
             * транспорт
             * участники
             * фотографии
             */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
