<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class News extends Model
{
    use HasFactory, Searchable;

    protected $guarded = ["id", "created_at", "updated_at"];

    public function searchableAs(): string
    {
        return 'news_index';
    }

    public function toSearchableArray(): array
    {
        $array = $this->toArray();
 
        $array['resource'] = $this->resource->name;
 
        return $array;
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
