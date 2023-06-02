<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public $timestamps = false;

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function instagramPosts()
    {
        return $this->hasMany(Instagram::class);
    }

    public function tweets()
    {
        return $this->hasMany(Twitter::class);
    }
}
