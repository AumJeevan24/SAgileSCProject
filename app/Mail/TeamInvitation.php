<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $role;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function build()
    {
        return $this->view('team.team_invitation')
                    ->subject('Invitation to Join Team');
    }
}
