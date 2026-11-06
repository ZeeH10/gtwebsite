<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Key/value site settings edited on the "Site settings" admin page; fall back to config/church.php. */
class Setting extends Model
{
    protected $primaryKey = 'key';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $guarded = [];

    private static ?array $cache = null;

    /** Editable keys and their starting values (from config/church.php). */
    public static function defaults(): array
    {
        $c = config('church');

        return [
            'pastor_name' => $c['pastor']['name'],
            'pastor_title' => $c['pastor']['title'],
            'pastor_bio' => implode("\n\n", $c['pastor']['bio']),
            'story' => implode("\n\n", $c['story']),
            'bank' => $c['giving']['bank'],
            'account_name' => $c['giving']['account_name'],
            'account_number' => $c['giving']['account_number'],
            'branch_code' => $c['giving']['branch_code'],
            'youtube' => $c['youtube'],
            'information_officer' => null,
            'information_officer_contact' => null,
        ];
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        try {
            self::$cache ??= static::query()->pluck('value', 'key')->all();
        } catch (\Throwable) {
            self::$cache = []; // e.g. before migrations have run
        }

        return filled(self::$cache[$key] ?? null) ? self::$cache[$key] : ($default ?? static::defaults()[$key] ?? null);
    }

    /** Text split into paragraphs on blank lines. */
    public static function paragraphs(string $key): array
    {
        return array_values(array_filter(array_map('trim', preg_split("/\R\s*\R/", (string) static::get($key)))));
    }

    public static function put(array $values): void
    {
        foreach ($values as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        self::$cache = null;
    }
}
