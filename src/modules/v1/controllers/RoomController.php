<?php
declare(strict_types=1);

namespace app\modules\v1\controllers;

use app\modules\v1\services\RoomService;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class RoomController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviors;
    }

    /**
     * @throws BadRequestHttpException
     */
    public function actionIndex(): array
    {
        $from = Yii::$app->request->getQueryParam('from');
        $to = Yii::$app->request->getQueryParam('to');
        if (empty($from) || empty($to))
            throw new BadRequestHttpException('Invalid query params');

        $service = new RoomService();
        return $service->getFreeRoom($from, $to);
    }
}
