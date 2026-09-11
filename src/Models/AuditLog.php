<?php

namespace App\Models;

use yii\db\ActiveRecord;

/**
 * @property string $id
 * @property string|null $user_id
 * @property string $action
 * @property string $entity
 * @property string|null $entity_id
 * @property array|null $old_values
 * @property array|null $new_values
 * @property string $created_at
 */
final class AuditLog extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'audit_logs';
    }
}