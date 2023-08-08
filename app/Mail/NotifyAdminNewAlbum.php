<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyAdminNewAlbum extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $album;

    /**
     * Create a new message instance.
     */
    public function __construct($admin, $album)
    {
        $this->admin = $admin;
        $this->album = $album;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.notifyadminnewalbum')
            ->subject('Notify Admin New Album')
            ->with([
                'admin' => $this->admin,
                'album' => $this->album,
            ]);
    }
}
