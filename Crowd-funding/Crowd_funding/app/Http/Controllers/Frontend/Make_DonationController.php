<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donaters;

class Make_DonationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'Donation_amount' => 'required|integer',
            'Donater_name' => 'required|string|max:225',
            'Donater_email' => 'required|email|max:225',
            'Donater_comment' => 'nullable|string|max:225',
        ]);
        
        Donaters::create([
            'Donation_amount' => $request->input('Donation_amount'),
            'Donater_name' => $request->input('Donater_name'),
            'Donater_email' => $request->input('Donater_email'),
            'Donater_comment' => $request->input('Donater_comment', ''),
        ]);

        return redirect()->back()->with('success', 'Donation successful. Thanks for your support.');
    }
}
