<?php

namespace App\Mail;

use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mime\Email;
use Illuminate\Support\Facades\Event;

class CampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    public $campaign;

    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function build()
    {
        // Use the sender name from the campaign table
        $senderName = $this->campaign->sender_name;

        return $this->from(config('mail.from.address'), $senderName) // Set the sender's name from the campaign
            ->subject($this->campaign->email_subject)
            ->view('emails.campaign') // Adjust to your email view path
            ->with([
                'campaign' => $this->campaign,
                'campaign_id' => $this->campaign->id,
            ]);

        // Dispatch the MessageSending event with the email and the data
        event(new \Illuminate\Mail\Events\MessageSending(
            new Email($email),
            ['campaign_id' => $this->campaign->id]
        ));
    }
}
