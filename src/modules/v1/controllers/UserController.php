<?php
declare(strict_types=1);

namespace app\modules\v1\controllers;

use app\modules\v1\services\UserService;
use Exception;
use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class UserController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        unset($behaviors['rateLimiter']);
        return $behaviors;
    }

    /**
     * @throws BadRequestHttpException
     */
    public function actionLogin(): string
    {
        $name = (string)Yii::$app->request->getBodyParam('name');
        $password = (string)Yii::$app->request->getBodyParam('password');

        try {
            return (new UserService())->login($name, $password);
        } catch (Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
