<?php
declare(strict_types=1);

namespace app\modules\v1\components;

use Ramsey\Uuid\Uuid;

class Id
{
    public function __construct(
        private string $id
    )
    {
    }

    public static function next(): self
    {
        return new self((string)Uuid::uuid4());
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
