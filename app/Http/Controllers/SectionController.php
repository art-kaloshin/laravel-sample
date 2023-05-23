<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Http\Resources\SectionResource;
use App\Http\Resources\SectionResourceCollection;
use App\Models\Section;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SectionResourceCollection::make(
            Section::with('sections')
                ->whereNull('parent_id')
                ->orWhere('parent_id', 0)
                ->orderBy('title')
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionRequest $request): SectionResource
    {
        $section = new Section();
        $section->title = $request->title;
        $section->parent_id = $request->parent_id;
        $section->save();

        return SectionResource::make($section);
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section): SectionResource
    {
        return SectionResource::make($section);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectionRequest $request, Section $section): SectionResource
    {
        $section->title = $request->title;
        $section->parent_id = $request->parent_id;
        $section->save();

        return SectionResource::make($section);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section): array
    {
        return ['status' => $section->delete()];
    }
}
