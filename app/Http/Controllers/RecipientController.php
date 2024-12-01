<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Recipient;
use App\Models\SubFolder;
use Illuminate\Http\Request;

class RecipientController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            // 'email' => 'required|email',
        ]);

        Recipient::create([
            'campaign_id' => $request->input('campaign_id'),
            // 'email' => $request->input('email'),
        ]);

        return back()->with('success', 'Recipient added successfully.');
    }

    public function addRecipient(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'sub_folder_id' => 'required|integer|exists:sub_folders,id'
        ]);

        // Check if the recipient already exists with the same campaign and sub folder
        $existingRecipient = Recipient::where('campaign_id', $campaign->id)
            ->where('sub_folder_id', $validated['sub_folder_id'])
            ->first();

        if (!$existingRecipient) {
            $recipient = new Recipient();
            $recipient->campaign()->associate($campaign);
            $recipient->subFolder()->associate(SubFolder::find($validated['sub_folder_id']));
            $recipient->save();

            return redirect()->back()->with('alert', 'Receipients Added Succesfully!');
        } else {
            return redirect()->back()->with('alert', 'The SubFolder already exists for this recipient list!');
        }
    }

}
