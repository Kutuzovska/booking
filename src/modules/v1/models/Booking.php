<?php
declare(strict_types=1);

namespace app\modules\v1\models;

use app\modules\v1\components\Id;
use Yii;
use yii\db\ActiveRecord;

/**
 * @property string id
 * @property string room_id
 * @property string user_id
 * @property string from
 * @property string to
 */
class Booking extends ActiveRecord
{
    public function __construct($config = [])
    {
        if (empty($this->id))
            $this->id = Id::next();

        parent::__construct($config);
    }

    public static function tableName(): string
    {
        return '{{%booking}}';
    }

    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT] = ['room_id', 'from', 'to'];
        return $scenarios;
    }

    public function rules(): array
    {
        return [
            [['room_id', 'from', 'to'], 'required'],
        ];
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            $this->user_id = Yii::$app->user->getId();
            return true;
        }

        return false;
    }

    public function getLastError(): string
    {
        return current($this->errors)[0];
    }

}
