<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CampaignMail;
use App\Models\Template;
use App\Models\Recipient;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendCampaignEmails; // Job to handle email sending
use App\Mail\CampaignEmail;
use App\Models\SubFolder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CampaignController extends Controller
{
    public function index()
    {
        // Fetch campaigns with calculated totals
        $campaigns = Campaign::withSum('sentEmails as total_open_count', 'opens')
            ->withSum('sentEmails as total_click_count', 'clicks')
            ->withCount('sentEmails as total_emails_sent')
            ->paginate(10);

        // Transform the paginated items
        $campaigns->getCollection()->transform(function ($campaign) {
            // Calculate rates in PHP
            $campaign->open_rate = $campaign->total_emails_sent > 0
                ? ($campaign->total_open_count / $campaign->total_emails_sent) * 100
                : 0;
            $campaign->click_rate = $campaign->total_emails_sent > 0
                ? ($campaign->total_click_count / $campaign->total_emails_sent) * 100
                : 0;
            return $campaign;
        });

        return view('campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        $templates = Template::all();
        return view('campaigns.create', compact('templates'));
    }

/*     public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'email_subject' => 'required|string|max:255',
            'email_body' => 'required|string',
            'scheduled_at' => 'nullable|date',
        ]);

        // Use Auth::id() or the hidden user_id passed from the form
        $userId = $request->input('user_id') ?? Auth::id();

        // Create the campaign
        Campaign::create([
            'user_id' => $userId,  // Store the authenticated user's ID
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'email_subject' => $validatedData['email_subject'],
            'email_body' => $validatedData['email_body'],
            'scheduled_at' => $validatedData['scheduled_at'],
        ]);

        // Redirect back to the campaign list with a success message
        return redirect()->route('campaigns.index')->with('success', 'Campaign created successfully.');
    } */


    // Inside your CampaignController
    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'email_subject' => 'required|string|max:255',
            'scheduled_at' => 'nullable|date',
            'sender_name' => 'required|string',
            'email_body_json' => 'required|string',
            'email_body_html' => 'required|string',
        ]);

        // Assuming the email_body is being passed as a JSON string from the form
       // $emailBodyJson = $request->input('email_body');   Contains the Unlayer JSON data

        // Create the campaign
        $campaign = new Campaign();
        $campaign->name = $validatedData['name'];
        $campaign->description = $validatedData['description'];
        $campaign->email_subject = $validatedData['email_subject'];
        $campaign->email_body_html = $validatedData['email_body_html'];
        $campaign->email_body_json = $validatedData['email_body_json'];
        $campaign->user_id = $request->user()->id;
        $campaign->status = 'pending';
        $campaign->sender_name = $validatedData['sender_name'];
        $campaign->save();

        // If scheduled_at is provided, schedule the email sending
        if ($campaign->scheduled_at) {
            SendCampaignEmails::dispatch($campaign)->delay($campaign->scheduled_at);
        } else {
            // Otherwise, send immediately
            SendCampaignEmails::dispatch($campaign);
        }

        // Redirect back with a success message
        return redirect()->route('campaigns.index')->with('success', 'Campaign created successfully!');
    }


    public function show($id)
{
    // Retrieve the campaign or fail
    $campaign = Campaign::findOrFail($id);

    // Retrieve recipients with their associated subFolder
    $recipients = Recipient::with('subFolder')->where('campaign_id', $campaign->id)->get();

    // Initialize a collection for contact lists
    $contactLists = collect();

    // Loop through recipients to gather contact lists from their subFolders
    foreach ($recipients as $recipient) {
        $subFolder = $recipient->subFolder;
        if ($subFolder) {
            $contactLists = $contactLists->merge($subFolder->contactLists);
        }
    }

    // Remove duplicates from the contact lists based on email
    $uniqueContactLists = $contactLists
        ->filter(function($contactList) {
            return !is_null($contactList->email);
        })
        ->unique('email');

    // Retrieve all subFolders
    $subFolders = SubFolder::all();

    // Return the view with all necessary data
    return view('campaigns.show', [
        'campaign' => $campaign,
        'subFolders' => $subFolders,
        'recipients' => $recipients,
        'contactLists' => $uniqueContactLists,
    ]);
}

    public function edit($id)
    {
        // Fetch the campaign from the database
        $campaign = Campaign::findOrFail($id);

        // Return the edit view with the campaign data
        return view('campaigns.edit', compact('campaign'));
    }

    // Update the campaign details
    public function update(Request $request, $id)
    {
        // Validate the form inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'email_subject' => 'required|string|max:255',
            'scheduled_at' => 'nullable|date',
            'sender_name' => 'required|string|max:255',
            'email_body_json' => 'required|json',
            'email_body_html' => 'required|string',
        ]);

        // Fetch the campaign
        $campaign = Campaign::findOrFail($id);

        // Update the campaign details
        $campaign->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'email_subject' => $request->input('email_subject'),
            'scheduled_at' => $request->input('scheduled_at'),
            'sender_name' => $request->input('sender_name'),
            'email_body_json' => $request->input('email_body_json'),
            'email_body_html' => $request->input('email_body_html'),
        ]);

        // Optionally, redirect the user to a page with a success message
        return redirect()->route('campaigns.show', $campaign->id)
                         ->with('success', 'Campaign updated successfully!');
    }

    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);

        // Delete the campaign
        $campaign->delete();

        // Redirect back with a success message
        return redirect()->route('campaigns.index')
                        ->with('success', 'Campaign deleted successfully!');
    }

    public function sendCampaign(Request $request, Campaign $campaign)
    {
        // Validate request (you can add more validation if needed)
        /* $request->validate([
            'recipient_emails' => 'required|array',
            'recipient_emails.*' => 'email',
        ]);

        // Loop through each email and send the campaign
        foreach ($request->recipient_emails as $recipientEmail) {
            Mail::to($recipientEmail)->send(new CampaignMail($campaign));
        }

        return redirect()->route('campaigns.index')->with('success', 'Campaign sent successfully to all recipients.'); */
        /* $testEmail = $request->input('test_email', 'test@example.com'); // Default test email if none provided

        // Send the campaign email
        Mail::to($testEmail)->send(new CampaignMail($campaign));

        return redirect()->route('campaigns.show', $campaign->id)->with('success', 'Campaign sent to ' . $testEmail); */
        $request->validate([
            'test_email' => 'required|email',
        ]);

        $testEmail = $request->input('test_email');

        Mail::to($testEmail)->send(new CampaignMail($campaign));

        return redirect()->route('campaigns.show', $campaign->id)->with('success', 'Campaign sent to ' . $testEmail);
    }

    public function sendCampaignEmail($campaignId)
    {
        // Fetch the campaign from the database
        $campaign = Campaign::findOrFail($campaignId);

        // Assuming we want to send the email to all users related to this campaign (adjust as needed)
        $users = $campaign->user; // Or any other logic to get the recipients

        // Send the email to each recipient (example with one user)
        Mail::to($users->email)->send(new CampaignMail($campaign));

        // Optionally, return a response
        return response()->json(['message' => 'Campaign email sent successfully!']);
    }

    public function sendToAll(Campaign $campaign)
    {
        // Check if the campaign has recipients
        $recipients = Recipient::where('campaign_id', $campaign->id)->get();

        if ($recipients->isEmpty()) {
            return redirect()->route('campaigns.show', $campaign->id)
                            ->with('error', 'No recipients found for this campaign.');
        }

        // Send emails to all recipients
        foreach ($recipients as $recipient) {
            foreach ($recipient->subFolder->contactLists as $contactList) {
                Mail::to($contactList->email)->send(new CampaignMail($campaign));
            }
        }

        // Update the campaign's status to 'sent'
        $campaign->update([
            'status' => 'sent',
        ]);

        return redirect()->route('campaigns.show', $campaign->id)
                        ->with('success', 'Campaign sent to all recipients.');
    }


   /*  public function sendToAll(Campaign $campaign)
    {
        // Check if the campaign is scheduled
        if ($campaign->scheduled_at && now()->lt($campaign->scheduled_at)) {
            return redirect()->route('campaigns.show', $campaign->id)
                            ->with('error', 'The campaign is scheduled to be sent later.');
        }

        // Get all recipients of the campaign
        $recipients = Recipient::where('campaign_id', $campaign->id)->get();

        if ($recipients->isEmpty()) {
            return redirect()->route('campaigns.show', $campaign->id)
                            ->with('error', 'No recipients found for this campaign.');
        }

        foreach ($recipients as $recipient) {
            Mail::to($recipient->email)->send(new CampaignMail($campaign));

            // Mark the email as sent
            $recipient->update(['sent' => true]);
        }

        return redirect()->route('campaigns.show', $campaign->id)
                        ->with('success', 'Campaign sent to all recipients.');
    } */

    public function schedule(Request $request, Campaign $campaign)
    {
        // Validate the schedule time
        $request->validate([
            'schedule_time' => 'required|date|after:now',
        ]);

        // Update the campaign's scheduled_at time in the database
        $campaign->update([
            'scheduled_at' => $request->input('schedule_time'),
            'status' => 'scheduled',
        ]);

        // Dispatch the job to send the campaign emails at the scheduled time
        SendCampaignEmails::dispatch($campaign)->delay($campaign->scheduled_at);

        return redirect()->route('campaigns.show', $campaign->id)
                         ->with('success', 'Campaign scheduled successfully.');
    }

    public function deleteReceipient($campaignId, $recipientId)
    {
        // Find the recipient by ID and delete it
        $recipient = Recipient::findOrFail($recipientId);
        $recipient->delete();

        // Redirect back with a success message
        return redirect()->back()->with('alert', 'Recipient deleted successfully.');
    }

        public function duplicate($id)
    {
        // Find the existing campaign by ID
        $campaign = Campaign::findOrFail($id);

        // Create a new campaign with the same properties
        $newCampaign = $campaign->replicate(); // Use replicate to copy the model

        // Modify the name to distinguish it
        $newCampaign->name = $campaign->name . ' (Copy)';

        // Set the status of the new campaign to 'pending'
        $newCampaign->status = 'pending'; // Set the desired status

        $newCampaign->scheduled_at = NULL;
        // Save the new campaign to the database
        $newCampaign->save();

        // Redirect back with a success message
        return redirect()->route('campaigns.index')->with('success', 'Campaign duplicated successfully with status set to pending.');
    }

}
