<?php
declare(strict_types=1);

namespace app\modules\v1\controllers;

use app\modules\v1\models\DateInterval;
use app\modules\v1\services\BookingService;
use Exception;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class BookingController extends Controller
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
    public function actionCreate()
    {
        $roomTypeId = (string)Yii::$app->request->getBodyParam('room_type_id');
        $from = (string)Yii::$app->request->getBodyParam('from');
        $to = (string)Yii::$app->request->getBodyParam('to');

        try {
            $dateInterval = new DateInterval($from, $to);
            (new BookingService())->book($roomTypeId, $dateInterval);
        } catch (Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
