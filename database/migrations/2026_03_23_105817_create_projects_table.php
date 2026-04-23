<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates the 'projects' table used to store all project
     * records belonging to registered users. Each project is
     * linked to a user through a foreign key.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            // Foreign key linking project → user
            $table->unsignedBigInteger('uid');

            // Core project fields
            $table->string('title');
            $table->text('short_description');
            $table->date('start_date');
            $table->date('end_date')->nullable();

            // Project phase
            $table->enum('phase', [
                'design',
                'development',
                'testing',
                'deployment',
                'complete',
            ]);

            $table->timestamps();

            // Indexes for performance
            $table->index('uid');
            $table->index('phase');

            // Enforce relational integrity
            $table->foreign('uid')
                  ->references('id')->on('users')
                  ->onDelete('cascade'); // Delete projects if user is deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * Drops the 'projects' table if it exists.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
