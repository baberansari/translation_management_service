<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Translation extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'locale', 'value', 'tags'];
    protected $casts = ['tags' => 'array'];

    protected static function newFactory()
    {
        return \Database\Factories\TranslationFactory::new();
    }
}
