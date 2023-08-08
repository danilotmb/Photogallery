<?php

namespace App\Listeners;

use App\Events\NewAlbumCreated;
use App\Mail\NotifyAdminNewAlbum as NotifyAdmin;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyAdminNewAlbum
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewAlbumCreated $event): void
    {
        $admins = User::select(['email','name'])->where('user_role', 'admin')->get();
        foreach($admins as $admin)
            {
                Mail::to($admin->email)->send(new NotifyAdmin($admin, $event->album));
            }
    }
}
