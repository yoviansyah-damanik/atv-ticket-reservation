<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class MailType extends Enum
{
    const ClientReservationNotification = 'client_reservation_notification';
    const ReservationNotification = 'reservation_notification';
    const CancelReservation = 'cancel_reservation';
    const ReservationAccepted = 'reservation_accepted';
    const ReservationPayment = 'reservation_payment';
}
