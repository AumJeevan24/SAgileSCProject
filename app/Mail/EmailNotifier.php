<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailNotifier extends Mailable
{
    use Queueable, SerializesModels;

    
    public function __construct()
    {

    }

    public function build()
    {
        // return $this->view('team.team_invitation')
        //             ->subject('Invitation to Join Team');
        return $this->from('your-email@example.com', 'Team Leader')
                    ->markdown('Team.invitationEmailTest');
    }
}
