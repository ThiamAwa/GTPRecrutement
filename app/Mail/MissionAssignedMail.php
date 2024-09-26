<?php

namespace App\Mail;

use App\Models\Consultant;
use App\Models\Mission;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MissionAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mission;
    public $consultant;
    public $client;

    /**
     * Create a new message instance.
     */
    public function __construct(Mission $mission, Consultant $consultant,$client)
    {
        $this->mission = $mission;
        $this->consultant = $consultant;
        $this->client = $client;
    }


    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        // Generate the PDF using the mission and consultant data
        $pdf = PDF::loadView('invoice', [
            'mission' => $this->mission,
            'consultant' => $this->consultant,
            'client' => $this->client
        ]);

        // Build the email with the PDF attached
        return $this->from('awa96362@gmail.com', 'awa')
            ->view('mission_assigned') // Your email view
            ->with([
                'consultant' => $this->consultant,
                'mission' => $this->mission,
                'client' => $this->client
            ])
            ->attachData($pdf->output(), 'contract.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
