<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function build()
    {
        // return $this->view('team.team_invitation')
        //             ->subject('Invitation to Join Team');
        return $this->from('your-email@example.com', 'Your Name')
                    ->markdown('Team.invitationEmailTest');
    }
}
