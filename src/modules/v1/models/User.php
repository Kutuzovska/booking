<?php
declare(strict_types=1);

namespace app\modules\v1\models;

use Exception;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UnauthorizedHttpException;

/**
 * @property string $id
 * @property string $email
 * @property string $name
 * @property string $password
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName(): string
    {
        return '{{%users}}';
    }

    public static function findIdentity($id)
    {
    }

    /**
     * @throws UnauthorizedHttpException
     */
    public static function findIdentityByAccessToken($token, $type = null): User
    {
        try {
            $token = Yii::$app->jwt->validate($token);
        } catch (Exception $e) {
            throw new UnauthorizedHttpException($e->getMessage());
        }

        $user = new User();
        $user->id = $token->claims()->get('id');
        $user->name = $token->claims()->get('name');
        $user->email = $token->claims()->get('email');

        return $user;
    }

    public function generateToken(): string
    {
        return Yii::$app
            ->jwt
            ->getBuilder()
            ->withClaim('id', $this->getId())
            ->withClaim('name', $this->name)
            ->withClaim('email', $this->email)
            ->getToken(
                Yii::$app->jwt->getSinger(),
                Yii::$app->jwt->getSingerKey(),
            )->toString();
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getAuthKey()
    {
    }

    public function validateAuthKey($authKey)
    {
    }
}
