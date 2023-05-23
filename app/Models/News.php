<?php

namespace App\Models;

use App\Traits\Search;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Eloquent
 * @property string $title
 * @property string $description
 * @property string $text
 */
class News extends Model
{
    use HasFactory, Search, SoftDeletes;

    private array $searchable = [
        'title',
        'description',
        'text'
    ];

    public function sections(): BelongsToMany
    {
        return $this->belongsToMany(Section::class, 'news_to_sections');
    }

    public function search($terms): Builder
    {
        return $this->scopeSearch($this, $terms);
    }
}
