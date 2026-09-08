<?php

declare(strict_types=1);

namespace App\Models;

use yii\db\ActiveRecord;

final class User extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%users}}';
    }

    public function rules(): array
    {
        return [
            [['id', 'email', 'password_hash'], 'required'],
            [['roles'], 'safe'],
            [['id'], 'string', 'max' => 32],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 255],
            [['password_hash'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
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
}
