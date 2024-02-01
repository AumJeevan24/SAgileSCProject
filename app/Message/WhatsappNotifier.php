<?php

namespace App\Message;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class WhatsappNotifier extends Notification
{
  use Queueable;
  // protected $phoneNumber;


  // public function __construct(string $phoneNumber)
  // {
  //   // $this->phoneNumber = $phoneNumber;

  // }
  
  public function via($notifiable)
  {
    return [TeamController::class,'send'];
  }
  
  public function toWhatsApp($notifiable)
  {
    return $this->content("You are invite to join our team. please click the link below to join our team.");
    // return (new WhatsAppMessage)
    //     ->content("You are invite to join our team. please click the link below to join our team.");
  }
}
