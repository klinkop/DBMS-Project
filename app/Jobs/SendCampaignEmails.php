<?php

// Create the job: php artisan make:job SendCampaignEmails

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\Recipient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\CampaignMail;
use Exception;

class SendCampaignEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign;

    /**
     * Create a new job instance.
     *
     * @param Campaign $campaign
     */
    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    /* public function handle()
    {
        $recipients = $this->campaign->recipients(); // Assuming you have recipients

        foreach ($recipients as $recipient) {
            try {
                Mail::to($recipient->email)->send(new CampaignMail($this->campaign));
                Log::info('Email sent successfully to: ' . $recipient->email);
            } catch (\Exception $e) {
                Log::error('Failed to send email to: ' . $recipient->email . '. Error: ' . $e->getMessage());
            }
        }
    } */

    public function handle()
    {
        // Get all recipients of the campaign
        $recipients = Recipient::where('campaign_id', $this->campaign->id)->get();

        if ($recipients->isEmpty()) {
            // Optionally, log or handle the case when no recipients are found
            Log::info('No recipients found for Campaign ID: ' . $this->campaign->id);
            return;
        }

        $failed = false;

        foreach ($recipients as $recipient) {
            foreach ($recipient->subFolder->contactLists as $contactList) {
                $email = $contactList->email;

                // Skip if email is null or invalid
                if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    Log::warning('Skipped invalid or null email for Contact ID: ' . $contactList->id);
                    continue;
                }

                try {
                    Mail::to($email)->send(new CampaignMail($this->campaign));
                } catch (Exception $e) {
                    // Log the error and set the failed flag to true
                    Log::error('Failed to send email to ' . $email . ' for Campaign ID: ' . $this->campaign->id . '. Error: ' . $e->getMessage());
                    $failed = true;
                }
            }
        }

        if ($failed) {
            // Update status to 'failed' if any emails were not sent
            $this->campaign->update(['status' => 'failed']);
            Log::info('Status updated to "failed" for Campaign ID: ' . $this->campaign->id);
        } else {
            // Update status to 'sent' if all emails were successfully sent
            $this->campaign->update(['status' => 'sent']);
            Log::info('Status updated to "sent" for Campaign ID: ' . $this->campaign->id);
        }
    }


}
