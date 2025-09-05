<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Entity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class, 'application_entity');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'entity_user');
    }
}