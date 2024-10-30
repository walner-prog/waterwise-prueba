<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReciboCobroMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cliente;
    public $pdfPath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cliente, $pdfPath)
    {
        $this->cliente = $cliente;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.recibo-cobro')
                    ->subject('Recibo de Cobro')
                    ->attach($this->pdfPath, [
                        'as' => 'recibo-cobro.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
