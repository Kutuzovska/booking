<?php
declare(strict_types=1);

namespace app\modules\v1\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property int room_id
 * @property string email
 * @property string name
 * @property string from
 * @property string to
 */
class Reservation extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%reservation}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT] = ['room_id', 'email', 'name', 'from', 'to'];
        return $scenarios;

    }

    public function rules(): array
    {
        return [
            [['room_id', 'email', 'name', 'from', 'to'], 'required'],
            ['room_id', 'integer'],
            ['email', 'email'],
            ['name', 'string', 'min' => 1],
            [['from', 'to'], 'date', 'format' => 'Y-m-d'],
        ];
    }

    public function getRoom(): ActiveQuery
    {
        return $this->hasOne(Room::class, ['room_id' => 'id']);
    }

    public function getLastError(): string
    {
        return current($this->errors)[0];
    }

}
