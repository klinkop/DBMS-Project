<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Recipient;

use Illuminate\Http\Request;

class RecipientController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'email' => 'required|email',
        ]);

        Recipient::create([
            'campaign_id' => $request->input('campaign_id'),
            'email' => $request->input('email'),
        ]);

        return back()->with('success', 'Recipient added successfully.');
    }

    public function addRecipient(Request $request, Campaign $campaign)
    {
        // Validate the input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        // Check if the email already exists for the current campaign
        $existingRecipient = $campaign->recipients()->where('email', $validatedData['email'])->first();

        if ($existingRecipient) {
            return redirect()->back()->withErrors(['email' => 'This email is already added to this campaign.']);
        }

        // Add recipient to the campaign
        $campaign->recipients()->create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);

        return redirect()->route('campaigns.show', $campaign->id)->with('success', 'Recipient added successfully.');
    }

}
