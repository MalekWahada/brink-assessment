<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'original_url',
        'short_code',
        'expire_at',
        'visit_count',
        'last_visited_at',
    ];

    public static function createUrl(string $originalUrl, Carbon $expireAt): self
    {
        $existing = self::where('original_url', $originalUrl)->first();

        if ($existing) {
            $existing->expire_at = $expireAt;
            $existing->save();

            return $existing;
        }

        return self::create([
            'original_url' => $originalUrl,
            'short_code' => Url::generateShortcode(),
            'expire_at' => $expireAt,
        ]);
    }

    protected static function generateShortcode(): string
    {
        do {
            $shortcode = self::generateBase62Shortcode();
        } while (self::where('short_code', $shortcode)->exists());

        return $shortcode;
    }

    protected static function generateBase62Shortcode(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $length = 6;
        $shortcode = '';

        for ($i = 0; $i < $length; $i++) {
            $shortcode .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $shortcode;
    }
}
