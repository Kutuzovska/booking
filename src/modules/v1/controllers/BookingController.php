<?php
declare(strict_types=1);

namespace app\modules\v1\controllers;

use app\modules\v1\services\ReservationService;
use Exception;
use Yii;
use yii\base\InvalidConfigException;
use yii\rest\Controller;

class BookingController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        unset($behaviors['rateLimiter']);
        return $behaviors;
    }

    /**
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function actionCreate(): void
    {
//        $data = Yii::$app->request->getBodyParams();
//        $service = new ReservationService();
//        $service->book($data);
    }
}
