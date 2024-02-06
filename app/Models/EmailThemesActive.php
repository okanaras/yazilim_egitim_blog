<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailThemesActive extends Model
{
    protected $guarded = [];
    protected $table = "email_themes_active";

    public function theme(): BelongsTo
    {
        return $this->belongsTo(EmailTheme::class, "theme_type_id", "id");
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}