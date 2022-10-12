<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;
    protected $fillable = [ 'id', 'category', 'description', 'url', 'language', 'country', 'NG_Description', 'NG_Review' ];
    protected $casts = ['id' => 'string'];

    public function logos() {
        return $this->hasMany(SourceLogo::class);
    }

    public function sorts() {
        return $this->hasMany(SourceSort::class);
    }
}
