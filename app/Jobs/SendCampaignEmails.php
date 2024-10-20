<?php

// Create the job: php artisan make:job SendCampaignEmails

namespace App\Jobs;

use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\CampaignEmail;

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
    public function handle()
    {
        $recipients = $this->campaign->recipients(); // Assuming you have recipients

        foreach ($recipients as $recipient) {
            try {
                Mail::to($recipient->email)->send(new CampaignEmail($this->campaign));
                Log::info('Email sent successfully to: ' . $recipient->email);
            } catch (\Exception $e) {
                Log::error('Failed to send email to: ' . $recipient->email . '. Error: ' . $e->getMessage());
            }
        }
    }

}
