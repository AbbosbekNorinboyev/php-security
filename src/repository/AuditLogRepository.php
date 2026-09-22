<?php

declare(strict_types=1);

namespace App\repository;

use App\Models\AuditLog;

final class AuditLogRepository
{
    public function log(
        ?string $actorId,
        string $action,
        string $entity,
        ?string $entityId,
        ?array $oldValues,
        ?array $newValues,
    ): void {
        $log = new AuditLog();
        $log->setAttributes([
            'user_id' => $actorId,
            'action' => $action,
            'entity' => $entity,
            'entity_id' => $entityId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
        ], false);

        $log->save(false);
    }
}
