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
        Schema::create('monthly_reports', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->default();
            $table->string('month');
            $table->integer('year');
            $table->unsignedBigInteger('center_id');
            $table->unsignedBigInteger('liaison_officer_id');
            $table->decimal('total_amount', 12, 2)->nullable();
            $table->string('report_file')->nullable();

            $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
            $table->foreign('liaison_officer_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_reports');
    }
};
