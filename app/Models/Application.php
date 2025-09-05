<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'url',
        'icon',
        'category_id',
        'is_active',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function entities(): BelongsToMany
    {
        return $this->belongsToMany(Entity::class, 'application_entity');
    }

    public function directUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'application_user');
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'application_user_favorite');
    }

    public function deeplinks(): HasMany
    {
        return $this->hasMany(Deeplink::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'application_tag');
    }
}