<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsIndexRequest;
use App\Http\Requests\NewsRequest;
use App\Http\Resources\NewsResource;
use App\Http\Resources\NewsResourceCollection;
use App\Models\News;
use Illuminate\Database\Eloquent\Builder;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(NewsIndexRequest $request): NewsResourceCollection
    {
        $newsResult = News::with('sections')->orderByDesc('news.created_at')
            ->orderByDesc('news.id');

        $request->section > 0 && $newsResult->whereHas('sections', function (Builder $section) use ($request) {
            $section->where('sections.id', $request->section);
        });

        $request->filled('search') && $newsResult->search($request->search);

        return NewsResourceCollection::make($newsResult->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsRequest $request): NewsResource
    {
        $news = new News();
        $news->title = $request->title;
        $news->description = $request->description;
        $news->text = $request->text;
        $news->save();

        $news->sections()->sync(array_map(fn($item) => $item['id'], $request->section));

        return NewsResource::make($news);
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return NewsResource::make($news);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsRequest $request, News $news): NewsResource
    {
        $news->title = $request->title;
        $news->description = $request->description;
        $news->text = $request->text;

        $news->sections()->sync(array_map(fn($item) => $item['id'], $request->section));

        return NewsResource::make($news);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news): array
    {
        return ['status' => $news->delete()];
    }
}
