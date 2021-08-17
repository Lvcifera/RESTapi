<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'text'];

    public function tags()
    {
        return $this->hasMany(Tag::class, 'article_id', 'id');
    }
}
