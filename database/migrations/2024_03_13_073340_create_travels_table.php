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
        Schema::create('travels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country');
            $table->string('region');
            $table->string('start_point');
            $table->string('end_point');
            $table->text('points')->nullable();
            $table->float('distance');
            $table->integer('surface')->nullable();
            $table->integer('difficult')->nullable();
            $table->integer('escort')->nullable();
            $table->text('description1')->nullable();;
            $table->text('description2')->nullable();;
            $table->string('availability')->nullable();;
            $table->integer('draft');
            $table->string('secret')->nullable();
            $table->foreignId('author_id')->constrained('users');
            $table->integer('notifications_sent')->nullable();;
            $table->timestamps();

            $table->integer('status')->default(1);

            // от себя:
            $table->integer('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travels');
    }
};
