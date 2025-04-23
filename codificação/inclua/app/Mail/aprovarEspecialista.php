<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class aprovarEspecialista extends Mailable
{
    use Queueable, SerializesModels;

    private $especialistaId;
    private $codigo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($especialistaId, $codigo)
    {
        $this->especialistaId = $especialistaId;
        $this->codigo = $codigo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_USERNAME'), 'Plataforma Inclua')
            ->subject('Validar Especialista')
            ->markdown('emails.aprovar_especialista', ['especialistaId' => $this->especialistaId, 'codigo' => $this->codigo]);
    }
}
