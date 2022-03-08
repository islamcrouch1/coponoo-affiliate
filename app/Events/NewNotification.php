<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;


class NewNotification  implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;



    public $user_id;
    public $user_name;
    public $title_ar;
    public $title_en;
    public $body_ar;
    public $body_en;
    public $date;
    public $user_image;
    public $url;
    public $status;
    public $change_status;




    public function __construct($data = [])
    {
        $this->user_id = $data['user_id'];
        $this->user_name = $data['user_name'];
        $this->title_ar = $data['title_ar'];
        $this->title_en = $data['title_en'];
        $this->body_ar = $data['body_ar'];
        $this->body_en = $data['body_en'];
        $this->date = $data['date'];
        $this->user_image = $data['user_image'];
        $this->url = $data['url'];
        $this->status = $data['status'];
        $this->change_status = $data['change_status'];


    }



    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('new-notification');

        // return new Channel('new-notification');

        return ['new-notification'];

    }

    public function broadcastAs()
    {
        return 'notification-event';
    }




}
