<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Add_FundController extends Controller
{
    public function showForm()
    {
        return view('frontend.add_fund');
    }

    public function store(Request $request)
    {
        // Validation rules for a single image
        $request->validate([
            'Name' => 'required|string|max:255',
            'Contact_No' => 'required|string|max:20',
            'Email' => 'required|email|max:255',
            'Campaign_Title' => 'required|string|max:255',
            'Campaign_Description' => 'required|string',
            'Funding_Deadline' => 'required|date|after_or_equal:today',
            'Funding_Category' => 'required|string|max:255',
            'Address' => 'required|string|max:255',
            'Country' => 'required|string|max:255',
            'City' => 'required|string|max:255',
            'State' => 'required|string|max:255',
            'Zip' => 'required|string|max:10',
            'Funding_Goal' => 'required|numeric|min:0',
            'Budget_Breakdown' => 'required|string',
            'Government_ID' => 'required|string|max:20',
            'Bank_Name' => 'required|string|max:255',
            'Account_Name' => 'required|string|max:255',
            'Account_Number' => 'required|string|max:20',
            'CVC' => 'required|string|size:4',
            'Expiry_Date' => 'required|date',
            'Campaign_Images' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Handle single file upload
            $imagePath = null;
            if ($request->hasFile('Campaign_Images')) {
                $image = $request->file('Campaign_Images');
                $imagePath = $image->store('campaign_images', 'public');
            }

            // Create new Campaign instance
            $campaign = Campaign::create([
                'name' => $request->input('Name'),
                'contact_no' => $request->input('Contact_No'),
                'email' => $request->input('Email'),
                'campaign_title' => $request->input('Campaign_Title'),
                'campaign_description' => $request->input('Campaign_Description'),
                'funding_deadline' => $request->input('Funding_Deadline'),
                'funding_category' => $request->input('Funding_Category'),
                'address' => $request->input('Address'),
                'country' => $request->input('Country'),
                'city' => $request->input('City'),
                'state' => $request->input('State'),
                'zip' => $request->input('Zip'),
                'funding_goal' => $request->input('Funding_Goal'),
                'budget_breakdown' => $request->input('Budget_Breakdown'),
                'campaign_images' => $imagePath,
                'government_id' => $request->input('Government_ID'),
                'bank_name' => $request->input('Bank_Name'),
                'account_name' => $request->input('Account_Name'),
                'account_number' => $request->input('Account_Number'),
                'cvc' => $request->input('CVC'),
                'expiry_date' => $request->input('Expiry_Date'),
            ]);

            DB::commit();

            return redirect('/')->with('success', 'Campaign added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error adding campaign:', ['exception' => $e]);
            return redirect()->back()->with('error', 'An error occurred while adding the campaign.');
        }
    }
}
 