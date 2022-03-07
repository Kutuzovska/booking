<?php
declare(strict_types=1);

namespace app\modules\v1\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property string id
 * @property string type_id
 * @property string $comment
 */
class Room extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%rooms}}';
    }

    public function getType(): ActiveQuery
    {
        return $this->hasOne(RoomType::class, ['id' => 'type_id']);
    }
}
