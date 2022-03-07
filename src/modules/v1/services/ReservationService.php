<?php
declare(strict_types=1);

namespace app\modules\v1\services;

use app\modules\v1\models\Reservation;
use Exception;

class ReservationService
{
    /**
     * @throws Exception
     */
    public function book(array $data): void
    {
        $reservation = new Reservation();
        $reservation->attributes = $data;
        if (!$reservation->validate())
            throw new Exception($reservation->getLastError());

        // TODO: Проверка свободных номеров

        $reservation->save();
    }
}
