<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('_donators_data', function (Blueprint $table) {
            $table->id();
            $table->integer('Donation_amount');
            $table->string('Donater_name');
            $table->string('Donater_email');
            $table->string('Donater_comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('_donators_data');
    }
};
