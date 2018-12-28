<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BanReward extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $game;
    public $display_name;
    public $uid;

    public function __construct($game, $display_name, $uid)
    {
        $this->game         = $game;
        $this->display_name = $display_name;
        $this->uid          = $uid;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $sAppName = getenv("APP_NAME");
        return $this->view('emails.banReward')
            ->subject('[' . $sAppName . ']' . __("Khoá đổi thưởng"))
            ->with('gate', $sAppName)
            ->with('game', $this->game)
            ->with('display_name', $this->display_name)
            ->with('uid', $this->uid);
    }
}
