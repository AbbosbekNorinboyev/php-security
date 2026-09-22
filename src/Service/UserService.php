<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\User;
use App\repository\AuditLogRepository;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

final class UserService
{
    public function __construct(
        private readonly AuditLogRepository $auditLogRepository = new AuditLogRepository(),
    ) {
    }

    public function create(array $input): User
    {
        $user = new User([
            'scenario' => 'create',
            'id' => bin2hex(random_bytes(16)),
            'email' => $input['email'] ?? null,
            'roles' => ['ROLE_USER'],
        ]);
        $user->setPassword((string) ($input['password'] ?? ''));

        if (!$user->validate()) {
            return $user;
        }

        $user->save(false);

        $this->auditLogRepository->log(
            actorId: null,
            action: 'create',
            entity: 'user',
            entityId: $user->id,
            oldValues: null,
            newValues: $user->toArray(),
        );

        return $user;
    }

    /**
     * @return list<User>
     */
    public function list(): array
    {
        return User::find()
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
    }

    public function update(string $id, array $data): User
    {
        $user = User::findOne($id);

        if ($user === null) {
            throw new NotFoundHttpException('User not found');
        }

        $oldValues = $user->toArray();

        if (array_key_exists('email', $data)) {
            $user->email = (string) $data['email'];
        }

        if (array_key_exists('password', $data)) {
            $user->setPassword((string) $data['password']);
        }

        if (array_key_exists('roles', $data)) {
            $user->roles = is_array($data['roles'])
                ? $data['roles']
                : [(string) $data['roles']];
        } elseif (array_key_exists('role', $data)) {
            $user->roles = [(string) $data['role']];
        }

        if (!$user->save()) {
            throw new ServerErrorHttpException(
                json_encode($user->errors)
            );
        }

        $this->auditLogRepository->log(
            actorId: null,
            action: 'update',
            entity: 'user',
            entityId: $user->id,
            oldValues: $oldValues,
            newValues: $user->toArray(),
        );

        return $user;
    }

    public function delete(string $id): User
    {
        $user = User::findOne($id);

        if ($user === null) {
            throw new NotFoundHttpException('User not found');
        }

        $oldValues = $user->toArray();

        $user->delete();

        $this->auditLogRepository->log(
            actorId: null,
            action: 'delete',
            entity: 'user',
            entityId: $id,
            oldValues: $oldValues,
            newValues: null,
        );

        return $user;
    }
}