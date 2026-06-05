<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CintaDisponibleNotification extends Notification
{
    public function __construct(
        public $pelicula,
        public $formato
    ) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('¡Tu película está disponible! — PIXELVHS')
            ->greeting('Hola, ' . $notifiable->nombre)
            ->line("La película \"{$this->pelicula->titulo}\" en formato {$this->formato->nombre} ya está disponible.")
            ->action('RENTAR AHORA', url('/'))
            ->line('Tienes 24 horas para reclamarla antes de que pase al siguiente en la fila.');
    }

    public function toArray($notifiable): array
    {
        return [
            'id_pelicula' => $this->pelicula->id_pelicula,
            'titulo'      => $this->pelicula->titulo,
            'formato'     => $this->formato->nombre,
        ];
    }
}