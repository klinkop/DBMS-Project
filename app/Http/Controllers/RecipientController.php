<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\ContactList;
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
        // Validate the input
        // $validatedData = $request->validate([
            // 'name' => 'required|string|max:255',
            // 'email' => 'required|email',
            // 'sub_folder_id',
        // ]);

        // Check if the email already exists for the current campaign
        // $existingRecipient = $campaign->recipients()->where('email', $validatedData['email'])->first();

        // if ($existingRecipient) {
        //     return redirect()->back()->withErrors(['email' => 'This email is already added to this campaign.']);
        // }

        // Add recipient to the campaign
        // $campaign->recipients()->create([
            // 'name' => $validatedData['name'],
            // 'email' => $validatedData['email'],
        // ]);

        // return redirect()->route('campaigns.show', $campaign->id)->with('success', 'Recipient added successfully.');

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

        // Retrieve all contactLists associated with the specified subFolder
        // $contactLists = ContactList::where('sub_folder_id', $validated['sub_folder_id'])->get();

        // foreach ($contactLists as $contactList) {
        //     // check if the recipient already exists
        //     $existingRecipient = Recipient::where('campaign_id', $campaign->id)
        //         ->where('email', $contactList->email)
        //         ->first();

        //     if (!$existingRecipient) {
        //         // create new recipient
        //         Recipient::create([
        //             'campaign_id' => $campaign->id,
        //             'email' => $contactList->email,
        //             'sub_folder_id' => $validated['sub_folder_id'],
        //         ]);

        //         return redirect()->back()->with('alert', 'Recipients added succesfully!!');
        //     } else {
        //         return redirect()->back()->with('alert', 'The email already exists for this recipient list!');
        //     }
        // }


    }

}
