<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keywords extends Model
{
    use HasFactory;

    protected $table = "keywords";
    protected $fillable = [
        "story_id", "stories_id", "name"
    ];

    public $timestamps = false;
}
