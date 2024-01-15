<?php

namespace App\Models;

use Attribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Article extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    // protected $fillable=['name','status']; bu sekilde cok uzun suruyor

    public function getTagsToArrayAttribute(): array|false|null
    {
        if(!is_null($this->attributes['tags']))
            return explode(",", $this->attributes['tags']);
        return $this->attributes['tags'];
    }

    // protected function getTagsToStringAttribute(): string
    // {
    //     return is_array($this->tags) ? implode(',', $this->tags) : '';
    // }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, "id", "category_id");
    }
    public function user(): HasOne
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    public function comments(): HasMany
    {
        return $this->HasMany(ArticleComment::class, "article_id", "id");
    }

    public function articleLikes(): HasMany
    {
        return $this->hasMany(UserLikeArticle::class, "article_id", "id");
    }

    public function scopeStatus($query, $status)
    {
        if (!is_null($status)) {
            return $query->where("status", $status);
        }
    }
    public function scopeCategory($query, $category_id)
    {
        if (!is_null($category_id)) {
            return $query->where("category_id", $category_id);
        }
    }

    public function scopeUser($query, $user_id)
    {
        if (!is_null($user_id)) {
            return $query->where("user_id", $user_id);
        }
    }

    public function scopepublishDate($query, $publish_date)
    {
        if (!is_null($publish_date)) {
            $publish_date = Carbon::parse("publish_date")->format("Y-m-d H:i:s"); // tarihi formatladik
            $query->where("publish_date", $publish_date);
            // $query->where("publish_date", ">", $publish_date); burada 2. par olarak esitlik kucukluk buyukluk kontrolu de yapilabilinir
        }
    }
}