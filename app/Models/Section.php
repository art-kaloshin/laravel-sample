<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Eloquent
 * @property string $title
 * @property int $parent_id
 */
class Section extends Model
{
    use HasFactory, SoftDeletes;

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class, 'parent_id', 'id');
    }

    public function news(): HasManyThrough
    {
        return $this->hasManyThrough(News::class, 'news_to_sections');
    }
}
