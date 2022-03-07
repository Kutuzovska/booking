<?php
declare(strict_types=1);

namespace app\modules\v1\models;

use yii\db\ActiveRecord;

/**
 * @property string id
 * @property string name
 */
class RoomType extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%room_types}}';
    }
}
