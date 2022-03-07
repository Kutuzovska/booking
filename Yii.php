<?php
declare(strict_types=1);

use app\modules\v1\components\JWT;
use yii\base\Application;
use yii\BaseYii;

/**
 * @property JWT $jwt
 *  JWT $jwt
 */
abstract class Base extends Application
{
    /**
     * @psalm-property
     */
    public JWT $jwt;
}

/**
 * Yii bootstrap file.
 * Used for enhanced IDE code autocompletion.
 */
class Yii extends BaseYii
{
    /** @var Base */
    public static $app;
}
