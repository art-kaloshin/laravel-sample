<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;

trait Search
{
    /**
     *
     * @param  Builder  $query
     * @param  string  $term
     *
     * @return Builder
     */
    protected function scopeSearch(Builder $query, string $term): Builder
    {
        $columns = implode(',', $this->searchable);

        $query->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)", $this->fullTextWildcards($term));
        return $query;
    }

    /**
     *
     * @param  string  $term
     *
     * @return string
     */
    protected function fullTextWildcards(string $term): string
    {
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);
        $words = explode(' ', $term);
        foreach ($words as $key => $word) {
            if (strlen($word) >= 3) {
                $words[$key] = '+' . $word . '*';
            }
        }

        return implode(' ', $words);
    }
}
