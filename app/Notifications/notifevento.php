<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class notifevento extends Notification
{
    use Queueable;

    protected $emailusuario;
    protected $titulo;
    protected $tipo;
    protected $descripcion;
    protected $lugar;
    protected $fecha;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($emailusuario, $titulo, $tipo, $descripcion, $lugar, $fecha)
    {
        $this -> emailusuario = $emailusuario;
        $this -> titulo = $titulo;
        $this -> tipo = $tipo;
        $this -> descripcion = $descripcion;
        $this -> lugar = $lugar;
        $this -> fecha = $fecha;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Nuevo evento')
                    ->line('Te han invitado a un evento:')
                    ->line('Tipo de evento: ' . $this -> tipo)
                    ->line('Nombre del evento: ' . $this -> titulo)
                    ->line('Descripcion: ' . $this -> descripcion)
                    ->line('Lugar: ' . $this -> lugar)
                    ->line('Fecha y hora: ' . $this -> fecha);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
?>