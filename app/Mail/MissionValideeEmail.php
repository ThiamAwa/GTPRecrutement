<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MissionValideeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $mission;

    public function __construct($mission)
    {
        $this->mission = $mission;
    }

    /**
     * Get the message envelope.
     */

    /**
     * Get the message content definition.
     */


    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */



    public function build()
    {
        return $this->from('awa96362@gmail.com', 'awa')->
            view('mission_validee')
            ->subject('Mission Validée')
            ->with([
                'missionTitre' => $this->mission->titre,
                'dateFin' => $this->mission->date_fin,
            ]);
    }
}
