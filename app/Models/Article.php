<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [ 'source_id', 'author', 'title', 'description', 'url', 'urlToImage', 'publishedAt', 'NG_Description', 'NG_Review' ];
}
