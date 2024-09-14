<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donaters; // Ensure this import matches your model class

class Donation_detailsController extends Controller
{
    public function show($id)
    {
        $campaign = Campaign::find($id);
        $donators = Donaters::all(); // Fetch all records from the _donators_data table

        if (!$campaign) {
            abort(404, 'Campaign not found');
        }

        return view('frontend.donation_details', [
            'campaign' => $campaign,
            'donators' => $donators
        ]);
    }
}
