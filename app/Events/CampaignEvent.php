<?php

namespace App\Events;

use App\Notifications\UserParticipationNotification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Campaign;
use Log;

class CampaignEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**

     * Get the channels the event should broadcast on.

     *

     * @return \Illuminate\Broadcasting\Channel|array

     */

    public function campaignCreated(Campaign $campaign)
    {
        try {
            $user = \App\User::where('user_type','admin')->first();
            $notification = new UserParticipationNotification($user);
            $notification->email = env('ADMIN_MAIl_NOTIFICATION');
            $notification->subject = "Création d'une nouvelle campagne";
            $notification->content = trans('app.mail_hello')." Nouvelle Campagne crée '".$campaign->title."' de la part de ".$campaign->user->name." ".$campaign->user->first_name;
            $user->notify($notification->delay(20));
            Log::info("Campaign Created Event Fire: ".$campaign->title);
        } catch (Exception $e) {
           return false;
        }
    }



    /**

     * Get the channels the event should broadcast on.

     *

     * @return \Illuminate\Broadcasting\Channel|array

     */

    public function campaignUpdated(Campaign $campaign)

    {

        Log::info("Campaign Updated Event Fire: ".$campaign->title);

    }



    /**

     * Get the channels the event should broadcast on.

     *

     * @return \Illuminate\Broadcasting\Channel|array

     */

    public function campaignDeleted(Campaign $campaign)

    {

        Log::info("Campaign Deleted Event Fire: ".$campaign->title);

    }
}
