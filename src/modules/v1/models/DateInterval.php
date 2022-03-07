<?php
declare(strict_types=1);

namespace app\modules\v1\models;

use Exception;
use yii\base\Model;

class DateInterval extends Model
{
    /**
     * @throws Exception
     */
    public function __construct(
        private string $from,
        private string $to,
    )
    {
        parent::__construct([]);
        if (!$this->validate())
            throw new Exception('Invalid date interval');

        if ($this->to < $this->from) {
            $tmp = $this->to;
            $this->to = $this->from;
            $this->from = $tmp;
        }
    }

    public function rules(): array
    {
        return [
            [['from', 'to'], 'required'],
            [['from', 'to'], 'date', 'format' => 'Y-m-d'],
        ];
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }
}
