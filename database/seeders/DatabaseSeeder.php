<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\News;
use App\Models\Section;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    const SECTIONS_COUNT = 5;
    const NEWS_COUNT = 100;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Section::orderBy('id')->each(fn(Section $section) => $section->delete());
        News::orderBy('id')->each(fn(News $section) => $section->delete());

        Section::factory(self::SECTIONS_COUNT)->create();
        News::factory(self::NEWS_COUNT)->create();

        News::orderBy('id')->each(function (News $news) {
            Section::limit(rand(1, self::SECTIONS_COUNT))
                ->orderByRaw('rand()')
                ->each(function (Section $section) use ($news) {
                   $news->sections()->attach($section);
                });
        });
    }
}
