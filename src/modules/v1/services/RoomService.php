<?php
declare(strict_types=1);

namespace app\modules\v1\services;

use app\modules\v1\models\Booking;
use app\modules\v1\models\DateInterval;
use app\modules\v1\models\Room;
use Exception;
use yii\db\ActiveQuery;
use yii\db\Query;

class RoomService
{
    public function getFreeRooms(DateInterval $dateInterval): array
    {
        $rooms = Room::find()
            ->select(['COUNT(*) count', 'type_id'])
            ->where(['NOT IN', 'id', $this->queryBookedRooms($dateInterval)])
            ->groupBy('type_id');

        return (new Query())
            ->select(['rooms.count', 'room_types.name', 'room_types.id'])
            ->from(['rooms' => $rooms])
            ->leftJoin('room_types', 'rooms.type_id=room_types.id')
            ->all();
    }

    private function queryBookedRooms(DateInterval $dateInterval): ActiveQuery
    {
        return Booking::find()
            ->select('room_id')
            ->where('NOT (:from > "to" OR :to < "from")', [
                ':from' => $dateInterval->getFrom(),
                ':to' => $dateInterval->getTo(),
            ]);
    }

    /**
     * @throws Exception
     */
    public function getFreeRoom(string $typeId, DateInterval $dateInterval): string
    {
        $room = Room::find()
            ->where(['=', 'type_id', $typeId])
            ->andWhere(['NOT IN', 'id', $this->queryBookedRooms($dateInterval)])
            ->one();

        if ($room === null)
            throw new Exception('No available rooms');

        return $room->id;
    }
}
