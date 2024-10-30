<?php
namespace App\Jobs;

use App\Mail\NotificacionClientes;
use App\Models\Cliente;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EnviarNotificacionesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $subject;
    protected $content;
    protected $clientes;

    public function __construct($subject, $content, $clientes)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->clientes = $clientes;
    }

    public function handle()
    {
        foreach ($this->clientes as $cliente) {
            Mail::to($cliente->email)->send(new NotificacionClientes($this->subject, $this->content));
        }
    }
}
