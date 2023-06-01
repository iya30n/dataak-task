<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Twitter extends Model
{
    use HasFactory, Searchable;

    protected $guarded = ["id", "created_at", "updated_at"];

    public function searchableAs(): string
    {
        return 'tweets_index';
    }

    public function toSearchableArray(): array
    {
        $array = $this->toArray();
 
        // Customize the data array...
 
        return $array;
    }
}
