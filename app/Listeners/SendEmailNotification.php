<?php

namespace App\Listeners;

use App\Events\RequestStatusChanged;
use App\Mail\RequestStatusChanged as RequestStatusChangedMail;
use Illuminate\Support\Facades\Mail;

class SendEmailNotification
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
    public function handle(RequestStatusChanged $event): void
    {
        $model = $event->model;
        Mail::to($model->email)->send(new RequestStatusChangedMail($model));
    }
}
