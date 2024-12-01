<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Metric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrackingController extends Controller
{
    // tracking open
    public function trackOpen($campaign_id, $recipient_email)
    {
        // Log the open event
        Log::info('Open tracking hit', [
            'campaign_id' => $campaign_id,
            'recipient_email' => $recipient_email,
        ]);

        // update the metrics for the campaign
        Metric::where('campaign_id', $campaign_id)
        ->increment('impressions');

        // return a 1x1 pixel gif
        $pixel = base64_decode("R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==");
        return response($pixel, 200)
            ->header('Content-Type', 'image/png');
    }
}
