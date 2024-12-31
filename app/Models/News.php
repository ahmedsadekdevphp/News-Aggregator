<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'title',
        'url',
        'published_at',
        'category',
        'type',
        'source_id',
        'source',
        'author'
    ];
    protected $casts = [
        'published_at' => 'datetime',
    ];
}
