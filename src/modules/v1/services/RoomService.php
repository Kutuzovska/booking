<?php
declare(strict_types=1);

namespace app\modules\v1\services;

use app\modules\v1\models\Room;
use yii\db\Query;

class RoomService
{
    public function getFreeRoom(string $from, string $to): array
    {
        $roomsCount = Room::find()
            ->select(['COUNT(*) count', 'type_id'])
            ->groupBy('type_id');

//        -- SELECT COUNT(*) count, RT.name FROM rooms R
//    --     LEFT JOIN room_types RT on RT.id = R.type_id
//        --     WHERE R.id NOT IN (SELECT room_id FROM booking WHERE NOT('2022-03-10' > "to" OR '2022-03-12' < "from"))
//-- GROUP BY RT.id;
//

        return [];
    }
}
