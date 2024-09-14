<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_no',
        'email',
        'campaign_title',
        'campaign_description',
        'funding_deadline',
        'funding_category',
        'address',
        'country',
        'city',
        'state',
        'zip',
        'funding_goal',
        'budget_breakdown',
        'campaign_images',
        'government_id',
        'bank_name',
        'account_name',
        'account_number',
        'cvc',
        'expiry_date',
    ];
}
