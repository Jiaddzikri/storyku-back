<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stories extends Model
{
    use HasFactory;
    protected $table = "stories";

    protected $fillable = [
        "categories_id", "title", "author", "synopsis", "cover_image", "status"
    ];
    public $timestamps  = true;

    public function categories()
    {
        return $this->belongsTo(Categories::class);
    }

    public function keywords()
    {
        return $this->hasMany(Keywords::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapters::class);
    }
}

