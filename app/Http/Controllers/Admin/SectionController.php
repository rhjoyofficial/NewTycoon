<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSectionRequest;
use App\Http\Requests\Admin\UpdateSectionRequest;
use App\Models\AdBanner;
use App\Models\Section;
use Illuminate\Support\Facades\Log;

class SectionController extends Controller
{
    /**
     * Display a listing of the sections.
     */
    public function index()
    {
        $sections = Section::with('banner')->orderBy('order')->get();
        return view('admin.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new section.
     */
    public function create()
    {
        $banners = AdBanner::orderBy('order')->get();
        return view('admin.sections.create', compact('banners'));
    }

    /**
     * Store a newly created section in storage.
     */
    public function store(StoreSectionRequest $request)
    {
        try {
            $data = $request->validated();

            // Decode settings JSON if provided
            if (isset($data['settings'])) {
                $data['settings'] = json_decode($data['settings'], true);
            }

            Section::create($data);
            flash('Section created successfully.', 'success');
            return redirect()->route('admin.content.sections.index');
        } catch (\Exception $e) {
            Log::error("Section Store Error: " . $e->getMessage());
            flash('Failed to create section. Please try again.', 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified section.
     */
    public function edit(Section $section)
    {
        $banners = AdBanner::orderBy('order')->get();
        return view('admin.sections.edit', compact('section', 'banners'));
    }

    /**
     * Update the specified section in storage.
     */
    public function update(UpdateSectionRequest $request, Section $section)
    {
        try {
            $data = $request->validated();

            if (isset($data['settings'])) {
                $data['settings'] = json_decode($data['settings'], true);
            }

            $section->update($data);

            flash('Section updated successfully.', 'success');
            return redirect()->route('admin.content.sections.index');
        } catch (\Exception $e) {
            Log::error("Section Update Error: " . $e->getMessage());
            flash('Failed to update section. Please try again.', 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified section from storage.
     */
    public function destroy(Section $section)
    {
        try {
            $section->delete();

            flash('Section deleted successfully.', 'success');
            return redirect()->route('admin.content.sections.index');
        } catch (\Exception $e) {
            Log::error("Section Delete Error: " . $e->getMessage());
            flash('Failed to delete section. Please try again.', 'error');
            return redirect()->back();
        }
    }
}
