<?php

declare(strict_types=1);

use yii\db\Migration;

final class m260908_000001_create_users_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%users}}', [
            'id' => $this->string(32)->notNull(),
            'email' => $this->string(255)->notNull(),
            'password_hash' => $this->string(255)->notNull(),
            'roles' => 'JSONB NOT NULL DEFAULT \'["ROLE_USER"]\'::jsonb',
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->addPrimaryKey('pk-users-id', '{{%users}}', 'id');
        $this->createIndex('uq-users-email', '{{%users}}', 'email', true);
    }

    public function safeDown(): void
    {
        $this->dropTable('{{%users}}');
    }
}
