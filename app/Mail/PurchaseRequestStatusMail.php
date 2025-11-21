<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseRequestStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function build()
    {
        return $this->subject("Status Update for Request: {$this->request->reference}")
            ->view('emails.purchase_request_status')
            ->with([
                'request' => $this->request,
            ]);
    }
}
