<?php
declare(strict_types=1);

namespace app\modules\v1\services;

use app\modules\v1\models\User;
use Exception;
use Throwable;
use Yii;

class UserService
{
    /**
     * @throws Exception
     */
    public function login(string $name, string $password): string
    {
        $user = User::findOne(['name' => $name]);
        if (!$user || !Yii::$app->getSecurity()->validatePassword($password, $user->password))
            throw new Exception('Invalid name or password');

        try {
            return $user->generateToken();
        } catch (Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }
}
