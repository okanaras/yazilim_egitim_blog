<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailTheme extends Model
{
    protected $guarded = [];

    public const THEME_TYPE = [
        "Tema Turu Seciniz",
        "Kendim Icerik Olusturmak Istiyorum",
        "Parola Sifirlama Maili"
    ];

    public const PROCESS = [
        'Islem Seciniz',
        'Email Dogrulama Mail Icerigi',
        'Parola Sifirlama Mail Icerigi',
        'Parola Sifirlama Islem Tamamlandiginda Gonderilecek Mail Icerigi'
    ];

    public function getThemeTypeAttribute($value): string
    {
        return self::THEME_TYPE[$value];
    }
    public function getProcessAttribute($value): string
    {
        return self::PROCESS[$value];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}