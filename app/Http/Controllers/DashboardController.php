<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\ContactList;

class DashboardController extends Controller
{
    public function index()
        {
            // Get the latest campaign, checking both the scheduled_at and time_sent columns
            $latestCampaign = \App\Models\Campaign::where('status', 'sent')
                                                ->whereNotNull('time_sent')
                                                ->orderByRaw('GREATEST(scheduled_at, time_sent) DESC')
                                                ->first();

            $message = '';
            $recipientCount = 0;
            $subFolderNames = [];
            $totalEmailsSent = 0;

            if ($latestCampaign) {
                // Compare the 'time_sent' and 'scheduled_at' timestamps
                if ($latestCampaign->time_sent && $latestCampaign->time_sent > $latestCampaign->scheduled_at) {
                    // If 'time_sent' is newer than 'scheduled_at', pass the campaign info
                    $message = 'Campaign sent at ' . \Carbon\Carbon::parse($latestCampaign->time_sent)->format('l, F j, Y \a\t h:i A');
                } else {
                    // If 'scheduled_at' is newer or no 'time_sent', pass the campaign info
                    $message = 'Campaign sent as per the scheduled time at ' . \Carbon\Carbon::parse($latestCampaign->scheduled_at)->format('l, F j, Y \a\t h:i A') . '.';
                }

                // Get the recipients and subfolder names
                $recipients = \App\Models\Recipient::where('campaign_id', $latestCampaign->id)->get();
                $recipientCount = $recipients->count();
                $subFolderNames = $recipients->map(function ($recipient) {
                    return $recipient->subFolder->name;
                })->unique()->toArray(); // Get unique subfolder names

                // Calculate total emails sent (assuming you have a sentEmails relationship)
                $totalEmailsSent = $latestCampaign->sentEmails()->count();

            } else {
                // Handle the case where no sent campaign is found
                return redirect()->route('campaigns.index')->with('error', 'No sent campaign found.');
            }

            // Fetch additional data (campaign count, contact count)
            $campaignCount = Campaign::count();
            $contactCount = ContactList::count(); // Assuming you have a ContactList model

            // Return the dashboard view, passing necessary data
            return view('dashboard.index', compact('latestCampaign', 'message', 'campaignCount', 'contactCount','recipientCount', 'subFolderNames', 'totalEmailsSent'));
        }
       /*  public function test()
{
    $latestCampaign = \App\Models\Campaign::where('status', 'sent')
                                          ->orderBy('scheduled_at', 'desc')
                                          ->first();

    $message = '';
    $recipientCount = 0;
    $subFolderNames = [];
    $totalEmailsSent = 0;

    if ($latestCampaign) {
        // Compare the 'time_sent' and 'scheduled_at' timestamps
        if ($latestCampaign->time_sent && $latestCampaign->time_sent > $latestCampaign->scheduled_at) {
            $message = 'Campaign sent instantly at ' . \Carbon\Carbon::parse($latestCampaign->time_sent)->format('l, F j, Y \a\t h:i A') . '. Scheduled at ' . \Carbon\Carbon::parse($latestCampaign->scheduled_at)->format('l, F j, Y \a\t h:i A') . '.';
        } else {
            $message = 'Campaign sent as per the scheduled time at ' . \Carbon\Carbon::parse($latestCampaign->scheduled_at)->format('l, F j, Y \a\t h:i A') . '.';
        }

        // Get the recipients and subfolder names
        $recipients = \App\Models\Recipient::where('campaign_id', $latestCampaign->id)->get();
        $recipientCount = $recipients->count();
        $subFolderNames = $recipients->map(function ($recipient) {
            return $recipient->subFolder->name;
        })->unique()->toArray(); // Get unique subfolder names

        // Calculate total emails sent (assuming you have a sentEmails relationship)
        $totalEmailsSent = $latestCampaign->sentEmails()->count();
    } else {
        return redirect()->route('campaigns.index')->with('error', 'No sent campaign found.');
    }

    $campaignCount = \App\Models\Campaign::count();
    $contactCount = \App\Models\ContactList::count();

    return view('dashboard.index', compact('latestCampaign', 'message', 'campaignCount', 'contactCount', 'recipientCount', 'subFolderNames', 'totalEmailsSent'));
}
 */
}
