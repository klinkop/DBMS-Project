<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Campaign;
use Illuminate\Support\Facades\Log;

class EmailTrackingController extends Controller
{

    public function trackOpen(Request $request)
    {
        // Log the incoming request data
        Log::info('Tracking Pixel Request:', ['request' => $request->all()]);

        // Get the campaign ID from the query
        $campaignId = $request->query('campaign_id');
        Log::info('Campaign ID:', ['campaign_id' => $campaignId]);

        // Find the campaign using the ID
        $campaign = Campaign::find($campaignId);

        if ($campaign) {
            // Log the campaign found
            Log::info('Campaign found:', ['campaign_id' => $campaign->id, 'open_count' => $campaign->open_count]);

            // Increment the open count for the campaign
            $campaign->increment('open_count');

            // Log the updated open count
            Log::info('Open count incremented:', ['campaign_id' => $campaign->id, 'new_open_count' => $campaign->open_count]);
        } else {
            // Log if campaign is not found
            Log::warning('Campaign not found:', ['campaign_id' => $campaignId]);
        }

        // Return a 1x1 transparent GIF as the tracking pixel
        $transparentGif = base64_decode("R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==");
        return response($transparentGif, 200, [
            'Content-Type' => 'image/gif',
            'Content-Length' => strlen($transparentGif),
        ]);
    }


        public function trackClick(Request $request)
    {
        $campaignId = $request->query('campaign_id');
        $url = $request->query('url');

        $campaign = Campaign::find($campaignId);
        if ($campaign) {
            $campaign->increment('click_count');
        }

        // Redirect to the actual URL
        return redirect()->away($url);
    }

        public function trackBounce(Request $request)
    {
        $campaignId = $request->input('campaign_id');
        $campaign = Campaign::find($campaignId);

        if ($campaign) {
            $campaign->increment('bounce_count');
        }

        return response()->json(['message' => 'Bounce tracked successfully.']);
    }

}
