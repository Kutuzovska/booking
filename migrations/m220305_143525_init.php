<?php
declare(strict_types=1);

use yii\db\Migration;

class m220305_143525_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->string(36)->notNull()->unique(),
            'email' => $this->string(255)->notNull()->unique(),
            'name' => $this->string(255)->notNull(),
            'password' => $this->string(255)->notNull(),
        ]);
        $this->addPrimaryKey('users-id_pk', '{{%users}}', 'id');


        $this->createTable('{{%rooms}}', [
            'id' => $this->string(36)->notNull()->unique(),
            'comment' => $this->string(255)->notNull(),
            'type_id' => $this->string(36)->notNull(),
        ]);
        $this->addPrimaryKey('rooms-id_pk', '{{%rooms}}', 'id');


        $this->createTable('{{%room_types}}', [
            'id' => $this->string(36)->notNull()->unique(),
            'name' => $this->string(255)->notNull()->unique(),
        ]);
        $this->addPrimaryKey('room_types-id_pk', '{{%room_types}}', 'id');


        $this->createTable('{{%booking}}', [
            'id' => $this->string(36)->notNull()->unique(),
            'room_id' => $this->string(36)->notNull(),
            'user_id' => $this->string(36)->notNull(),
            'from' => $this->date()->notNull(),
            'to' => $this->date()->notNull(),
        ]);
        $this->addPrimaryKey('booking-id_pk', '{{%booking}}', 'id');


        $this->addForeignKey(
            'fk-rooms-type_id',
            '{{%rooms}}',
            'type_id',
            '{{%room_types}}',
            'id',
            'RESTRICT',
        );
        $this->addForeignKey(
            'fk-booking-room_id',
            '{{%booking}}',
            'room_id',
            '{{%rooms}}',
            'id',
            'RESTRICT',
        );
        $this->addForeignKey(
          'fk-booking-user_id',
            '{{%booking}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-booking-room_id', '{{%booking}}');
        $this->dropForeignKey('fk-booking-user_id', '{{%booking}}');
        $this->dropForeignKey('fk-rooms-type_id', '{{%rooms}}');

        $this->dropPrimaryKey('booking-id_pk', '{{%booking}}');
        $this->dropTable('{{%booking}}');

        $this->dropPrimaryKey('room_types-id_pk', '{{%room_types}}');
        $this->dropTable('{{%room_types}}');

        $this->dropPrimaryKey('rooms-id_pk', '{{%rooms}}');
        $this->dropTable('{{%rooms}}');

        $this->dropPrimaryKey('users-id_pk', '{{%users}}');
        $this->dropTable('{{%users}}');
    }
}
