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
        // Log the user ID when accessing the dashboard
        $userId = auth()->id();
        Log::info('Accessing dashboard by user ID: ' . $userId);

        // Get the latest campaign for the authenticated user
        $latestCampaign = Cache::remember('latest_campaign_user_' . $userId, now()->addMinutes(10), function () use ($userId) {
            return Campaign::where('user_id', $userId) // Filter campaigns by user ID
                ->where('status', 'sent')
                ->whereNotNull('time_sent')
                ->orderByRaw('GREATEST(scheduled_at, time_sent) DESC')
                ->first();
        });

        // Initialize default values
        $message = 'No campaigns have been sent yet.';
        $recipientCount = 0;
        $subFolderNames = [];
        $totalEmailsSent = 0;

        // If a latest campaign exists, process its details
        if ($latestCampaign) {
            $timeSent = $latestCampaign->time_sent;
            $scheduledAt = $latestCampaign->scheduled_at;

            // Determine the message based on timestamps
            if ($timeSent && $timeSent > $scheduledAt) {
                $message = 'Campaign sent at ' . \Carbon\Carbon::parse($timeSent)->format('l, F j, Y \a\t h:i A');
            } else {
                $message = 'Campaign sent as per the scheduled time at ' . \Carbon\Carbon::parse($scheduledAt)->format('l, F j, Y \a\t h:i A') . '.';
            }

            // Fetch recipient details for the campaign
            $recipients = \App\Models\Recipient::where('campaign_id', $latestCampaign->id)->get();

            $recipientCount = $recipients->count();
            $subFolderNames = $recipients->map(fn($recipient) => $recipient->subFolder->name)->unique()->toArray();

            // Calculate the total number of emails sent
            $totalEmailsSent = $latestCampaign->sentEmails()->count();
        }

        // Fetch additional data for the user's account
        $campaignCount = Campaign::where('user_id', $userId)->count();
        $contactCount = ContactList::where('user_id', $userId)->count();
        $parentFolderCount = ParentFolder::where('user_id', $userId)->count();
        $subFolderCount = SubFolder::where('user_id', $userId)->count();

        // Return the dashboard view, passing the necessary data
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
