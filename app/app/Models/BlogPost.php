<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'title',
        'body',
        'tags',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'tags' => 'array',
    ];

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'tags' => $this->tags,
            'published_at' => $this->published_at?->timestamp,
        ];
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id';
    }
}
