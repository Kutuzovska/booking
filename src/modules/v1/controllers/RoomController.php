<?php
declare(strict_types=1);

namespace app\modules\v1\controllers;

use app\modules\v1\models\DateInterval;
use app\modules\v1\services\RoomService;
use Exception;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class RoomController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = HttpBearerAuth::class;
        return $behaviors;
    }

    /**
     * @throws BadRequestHttpException
     */
    public function actionIndex(): array
    {
        $from = Yii::$app->request->getQueryParam('from');
        $to = Yii::$app->request->getQueryParam('to');

        try {
            $dateInterval = new DateInterval($from, $to);
            return (new RoomService())->getFreeRooms($dateInterval);
        } catch (Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
