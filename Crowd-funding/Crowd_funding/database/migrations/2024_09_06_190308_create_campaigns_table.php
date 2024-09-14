<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// Update migration file to use text for campaign_images
public function up()
{
    Schema::create('campaigns', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('contact_no');
        $table->string('email');
        $table->string('campaign_title');
        $table->text('campaign_description');
        $table->date('funding_deadline');
        $table->string('funding_category');
        $table->string('address');
        $table->string('country');
        $table->string('city');
        $table->string('state');
        $table->string('zip');
        $table->decimal('funding_goal', 20, 5);
        $table->text('budget_breakdown');
        $table->text('campaign_images')->nullable(); // Updated to text
        $table->string('government_id');
        $table->string('bank_name');
        $table->string('account_name');
        $table->string('account_number');
        $table->string('cvc');
        $table->date('expiry_date');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
