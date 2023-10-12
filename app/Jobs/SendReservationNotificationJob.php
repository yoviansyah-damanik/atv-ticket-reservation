<?php

namespace App\Jobs;

use App\Enums\MailType;
use App\Mail\CancelMail;
use App\Mail\PaymentMail;
use App\Mail\AcceptedMail;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationNotification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\ReservationNotificationMail;
use App\Mail\ClientReservationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Mail\ClientReservationNotificationMail;

class SendReservationNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $reservation, $email, $type;
    /**
     * Create a new job instance.
     */
    public function __construct(Reservation $reservation, $email, $type)
    {
        $this->reservation = $reservation;
        $this->email = $email;
        $this->type = $type;
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     *
     * @return array
     */
    public function backoff()
    {
        return [3, 5, 10];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->type == MailType::ReservationNotification)
            $view = new ReservationNotificationMail($this->reservation);
        elseif ($this->type == MailType::CancelReservation)
            $view = new CancelMail($this->reservation);
        elseif ($this->type == MailType::ReservationAccepted)
            $view = new AcceptedMail($this->reservation);
        elseif ($this->type == MailType::ClientReservationNotification)
            $view = new ClientReservationNotificationMail($this->reservation);
        elseif ($this->type == MailType::ReservationPayment)
            $view = new PaymentMail($this->reservation);

        if (is_string($this->email))
            Mail::to($this->email)
                ->send($view);
        else
            foreach ($this->email as $email)
                Mail::to($email)
                    ->send($view);
    }
}
