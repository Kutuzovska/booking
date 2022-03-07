<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/modules/v1/components/Id.php';

use app\modules\v1\components\Id;
use yii\db\Migration;

/**
 * Class m220307_115157_fake
 */
class m220307_115157_fake extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('users', [
            'id' => Id::next(),
            'name' => 'ivan',
            'email' => 'example@mail.com',
            'password' => Yii::$app->security->generatePasswordHash('ivan'),
        ]);

        $this->insert('users', [
            'id' => Id::next(),
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => Yii::$app->security->generatePasswordHash('admin')
        ]);

        $types = [
            'Одноместный' => 2,
            'Двуместный' => 4,
            'Люкс' => 3,
            'Де-Люкс' => 5,
        ];

        foreach ($types as $name => $count)
            $this->generateRoomTypes($name, $count);
    }

    private function generateRoomTypes(string $name, int $count): void {
        $type_id = Id::next();
        $this->insert('room_types', ['id' => $type_id, 'name' => $name]);
        $this->generateRooms($count, (string) $type_id);
    }

    private function generateRooms(int $count, string $type_id): void {
        for ($i = 1; $i <= $count; $i++) {
            $this->insert('rooms', [
                'id' => Id::next(),
                'comment' => $i,
                'type_id' => $type_id
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220307_115157_fake cannot be reverted.\n";

        return true;
    }
}
