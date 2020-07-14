<?php

namespace App\Http\Controllers\DiscordNotification;

use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

class TestNotification extends Notification
{
    public $challenger;

    public $game;

    public function __construct(Guild $challenger, Game $game)
    {
        $this->challenger = $challenger;
        $this->game = $game;
    }

    public function via($notifiable)
    {
        return [DiscordChannel::class];
    }

    public function toDiscord($notifiable)
    {
        return DiscordMessage::create("You have been challenged to a game of *{$this->game->name}* by **{$this->challenger->name}**!");
    }
}

>
