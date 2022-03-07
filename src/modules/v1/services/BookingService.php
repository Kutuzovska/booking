<?php
declare(strict_types=1);

namespace app\modules\v1\services;

use app\modules\v1\models\Booking;
use app\modules\v1\models\DateInterval;
use Exception;

class BookingService
{
    /**
     * @throws Exception
     */
    public function book(string $roomTypeId, DateInterval $dateInterval): void
    {
        $roomId = (new RoomService())->getFreeRoom($roomTypeId, $dateInterval);

        $booking = new Booking();
        $booking->room_id = $roomId;
        $booking->from = $dateInterval->getFrom();
        $booking->to = $dateInterval->getTo();
        if (!$booking->save())
            throw new Exception($booking->lastError);
    }
}
