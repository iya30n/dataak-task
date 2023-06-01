<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Instagram extends Model
{
    use HasFactory, Searchable;

    protected $guarded = ["id", "created_at", "updated_at"];

    protected $casts = ["images_gallery" => "array", "video_gallery" => "array"];

    public function searchableAs(): string
    {
        return 'instagram_index';
    }

    public function toSearchableArray(): array
    {
        $array = $this->toArray();
 
        // Customize the data array...
 
        return $array;
    }
}
