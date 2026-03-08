<?php

namespace App\Mail;

use App\Models\Store;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExportReadyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $store;
    public $filename;
    public $path;

    public function __construct(User $user, Store $store, string $filename, string $path)
    {
        $this->user = $user;
        $this->store = $store;
        $this->filename = $filename;
        $this->path = $path;
    }

    public function build()
    {
        return $this
            ->subject('Your store export is ready')
            ->view('emails.export-ready');
    }
}
