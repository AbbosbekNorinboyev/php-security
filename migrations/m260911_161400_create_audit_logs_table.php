<?php

declare(strict_types=1);

use yii\db\Migration;

final class m260911_161400_create_audit_logs_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%audit_logs}}', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->string(32)->null(),
            'action' => $this->string(50)->notNull(),
            'entity' => $this->string(100)->notNull(),
            'entity_id' => $this->string(100)->null(),
            'old_values' => $this->json()->null(),
            'new_values' => $this->json()->null(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            'idx-audit_logs-user_id',
            '{{%audit_logs}}',
            'user_id',
        );
        $this->createIndex(
            'idx-audit_logs-entity',
            '{{%audit_logs}}',
            ['entity', 'entity_id'],
        );
        $this->createIndex(
            'idx-audit_logs-created_at',
            '{{%audit_logs}}',
            'created_at',
        );
    }

    public function safeDown(): void
    {
        $this->dropTable('{{%audit_logs}}');
    }
}
