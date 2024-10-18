<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CampaignMail;
use App\Models\Template;
use App\Models\Recipient;

class CampaignController extends Controller
{
    public function index()
    {
        // Fetch campaigns with pagination (10 per page)
        $campaigns = Campaign::paginate(10);

        // Return the view with the campaigns data
        return view('campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        $templates = Template::all();
        return view('campaigns.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'email_subject' => 'nullable|string',
            'email_body' => 'nullable|string',
            'scheduled_at' => 'nullable|date',
        ]);

        Campaign::create($request->only('user_id', 'name', 'description', 'email_subject', 'email_body', 'scheduled_at'));

        return redirect()->route('campaigns.index')->with('success', 'Campaign created successfully.');
    }

    public function show($id)
    {
        $campaign = Campaign::findOrFail($id);

        return view('campaigns.show', compact('campaign'));
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
            'email_body' => 'required|string',
            'scheduled_at' => 'nullable|date',
        ]);

        // Fetch the campaign
        $campaign = Campaign::findOrFail($id);

        // Update the campaign details
        $campaign->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'email_subject' => $request->input('email_subject'),
            'email_body' => $request->input('email_body'),
            'scheduled_at' => $request->input('scheduled_at'),
        ]);

        // Optionally, redirect the user to a page with a success message
        return redirect()->route('campaigns.index')
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
    }

}
