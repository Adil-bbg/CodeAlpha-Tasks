<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Campaign;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch only the required data
        $campaigns = Campaign::select(
            'id',
            'campaign_title',
            'campaign_description',
            'campaign_images',
            'funding_goal'// Assuming you have an 'amount_raised' field
        )->get();

        return view('frontend.index', compact('campaigns'));
    }
}
