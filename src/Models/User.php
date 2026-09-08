<?php

declare(strict_types=1);

namespace App\Models;

use yii\db\ActiveRecord;

final class User extends ActiveRecord
{
    public string $password = '';

    public static function tableName(): string
    {
        return '{{%users}}';
    }

    public function rules(): array
    {
        return [
            [['email', 'password'], 'required', 'on' => ['create']],
            [['id', 'email', 'password_hash'], 'required'],
            [['roles'], 'safe'],
            [['id'], 'string', 'max' => 32],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 255],
            [['password_hash'], 'string', 'max' => 255],
            [['password'], 'string', 'min' => 8, 'on' => ['create']],
            [['email'], 'unique'],
        ];
    }

    public function beforeSave($insert): bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->password !== '' && (
            $this->password_hash === null
            || !password_verify($this->password, (string) $this->password_hash)
        )) {
            $this->password_hash = password_hash($this->password, PASSWORD_DEFAULT);
        }

        if (is_array($this->roles)) {
            $this->roles = json_encode($this->roles, JSON_THROW_ON_ERROR);
        }

        return true;
    }

    public function beforeValidate(): bool
    {
        if ($this->password_hash === null && $this->password !== '') {
            $this->password_hash = password_hash($this->password, PASSWORD_DEFAULT);
        }

        return parent::beforeValidate();
    }

    public function afterFind(): void
    {
        parent::afterFind();

        $this->decodeRoles();
    }

    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);

        $this->decodeRoles();
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function fields(): array
    {
        return [
            'id',
            'email',
            'roles',
            'created_at',
            'updated_at',
        ];
    }

    private function decodeRoles(): void
    {
        if (is_string($this->roles)) {
            $this->roles = json_decode($this->roles, true, 512, JSON_THROW_ON_ERROR);
        }
    }
}
