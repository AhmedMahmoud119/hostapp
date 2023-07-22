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
        Schema::create('host_jobs', function (Blueprint $table) {
            $table->id();

            $table->string('job_id');

            $table->foreignId('user_id')->nullable()->constrained();

            $table->string('event_name')->nullable();

            $table->boolean('status')->default(0);

            $table->string('error_code')->nullable();
            $table->string('message')->nullable();
            $table->text('json')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('host_jobs');
    }
};
