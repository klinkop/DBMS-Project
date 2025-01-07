<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\ContactList;
use App\Models\ParentFolder;
use App\Models\SubFolder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
        {
            // Log the user ID when they attempt to access the dashboard
            Log::info('Accessing dashboard by user ID: ' . auth()->id());

                // Get the latest campaign, checking both the scheduled_at and time_sent columns
            $latestCampaign = Cache::remember('latest_campaign', now()->addMinutes(10), function () {
                return \App\Models\Campaign::where('status', 'sent')
                    ->whereNotNull('time_sent')
                    ->orderByRaw('GREATEST(scheduled_at, time_sent) DESC')
                    ->first();
            });

            $message = '';
            $recipientCount = 0;
            $subFolderNames = [];
            $totalEmailsSent = 0;
            $parentFolderCount = 0;
            $subFolderCount = 0;

            if ($latestCampaign) {
                    $message = 'No campaigns have been sent yet.';
                    $recipientCount = 0;
                    $subFolderNames = [];
                    $totalEmailsSent = 0;
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
                $message = 'No campaigns have been sent yet.';
            }

            // Fetch additional data (campaign count, contact count)
            $campaignCount = Campaign::count();
            $contactCount = ContactList::count();
            $parentFolderCount = ParentFolder::count();
            $subFolderCount = SubFolder::count();

            // Return the dashboard view, passing necessary data
            if (!$latestCampaign) {
                // Set default values for the view when no campaign exists
                $latestCampaign = null;
                $message = 'No campaigns have been sent yet.';
                $recipientCount = 0;
                $subFolderNames = [];
                $totalEmailsSent = 0;
            }

            return view('dashboard.index', compact(
                'latestCampaign',
                'message',
                'campaignCount',
                'contactCount',
                'recipientCount',
                'subFolderNames',
                'totalEmailsSent',
                'parentFolderCount',
                'subFolderCount'
            ));
        }

}
