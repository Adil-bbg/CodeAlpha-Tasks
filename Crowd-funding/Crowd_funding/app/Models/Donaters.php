<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donaters extends Model
{
    use HasFactory;
    protected $table = '_donators_data';
    protected $fillable = [
        'Donation_amount',
        'Donater_name',
        'Donater_email',
        'Donater_comment',
    ];
}
