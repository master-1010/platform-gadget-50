<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    private const ENCRYPTED_KEYS = [
        'mail_password',
    ];

    public static function getValue(string $key, mixed $default = null): mixed
    {
        $value = static::query()->where('key', $key)->value('value');

        if ($value === null) {
            return $default;
        }

        return in_array($key, self::ENCRYPTED_KEYS, true) ? Crypt::decryptString($value) : $value;
    }

    public static function setValue(string $key, mixed $value): void
    {
        if (in_array($key, self::ENCRYPTED_KEYS, true)) {
            $value = Crypt::encryptString((string) $value);
        } elseif (is_array($value)) {
            $value = json_encode($value, JSON_THROW_ON_ERROR);
        }

        static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
