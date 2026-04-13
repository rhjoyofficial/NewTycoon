<?php

namespace App\Http\Controllers\Admin;

use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StoreHeroSlideRequest;
use App\Http\Requests\Admin\UpdateHeroSlideRequest;

class HeroSlideController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->paginate(10);
        $activeSlides = HeroSlide::active()->count();

        return view('admin.hero-slides.index', compact('slides', 'activeSlides'));
    }

    public function create()
    {
        return view('admin.hero-slides.create');
    }

    public function store(StoreHeroSlideRequest $request)
    {
        try {
            $data = $request->validated();

            // Handle background file upload
            if ($request->hasFile('background')) {
                $filename = 'slide-' . time() . '.' . $request->file('background')->extension();
                $data['background'] = $request->file('background')->storeAs('slides', $filename, 'public');
            }

            // Create slide
            HeroSlide::create($data);

            flash('Slide created successfully!', 'success', 5000);
            return redirect()->route('admin.hero-slides.index');
        } catch (\Exception $e) {
            Log::error('Error creating hero slide: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all(),
            ]);

            flash('Slide creation failed!', 'error', 8000, 'Please try again.');
            return redirect()->back()->withInput();
        }
    }

    public function edit(HeroSlide $heroSlide)
    {
        $maxOrder = HeroSlide::max('sort_order') ?? 0;

        return view('admin.hero-slides.edit', [
            'heroSlide' => $heroSlide,
            'maxOrder' => $maxOrder
        ]);
    }

    public function update(UpdateHeroSlideRequest $request, HeroSlide $heroSlide)
    {
        try {
            $data = $request->validated();

            // Handle background file update ONLY if a new file is uploaded
            if ($request->hasFile('background')) {
                // Delete old background if it exists
                if ($heroSlide->background && Storage::disk('public')->exists($heroSlide->background)) {
                    Storage::disk('public')->delete($heroSlide->background);
                }

                // Store new background
                $filename = 'slide-' . time() . '.' . $request->file('background')->extension();
                $data['background'] = $request->file('background')->storeAs('slides', $filename, 'public');
            } else {
                // Keep the existing background - remove it from the data array
                unset($data['background']);
            }

            // Update slide
            $heroSlide->update($data);

            flash('Slide updated successfully!', 'success', 5000);
            return redirect()->route('admin.hero-slides.index');
        } catch (\Exception $e) {
            Log::error('Error updating hero slide: ' . $e->getMessage(), [
                'exception' => $e,
                'slide_id' => $heroSlide->id,
                'request' => $request->all(),
            ]);

            flash('Slide update failed!', 'error', 8000, 'Please try again.');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(HeroSlide $heroSlide)
    {
        try {
            // Delete background file
            if ($heroSlide->background && Storage::disk('public')->exists($heroSlide->background)) {
                Storage::disk('public')->delete($heroSlide->background);
            }

            $heroSlide->delete();

            flash('Slide deleted successfully!', 'success', 5000);
            return redirect()->route('admin.hero-slides.index');
        } catch (\Exception $e) {
            Log::error('Error deleting hero slide: ' . $e->getMessage(), [
                'exception' => $e,
                'slide_id' => $heroSlide->id,
            ]);

            flash('Slide deletion failed!', 'error', 8000, 'Please try again.');
            return redirect()->back();
        }
    }

    public function toggleStatus(HeroSlide $heroSlide)
    {
        try {
            $heroSlide->is_active = !$heroSlide->is_active;
            $heroSlide->save();

            return response()->json([
                'success' => true,
                'is_active' => $heroSlide->is_active,
                'message' => 'Status updated successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error toggling slide status: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update status.'
            ], 500);
        }
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'slides' => 'required|array',
            'slides.*.id' => 'required|exists:hero_slides,id',
            'slides.*.sort_order' => 'required|integer',
        ]);

        try {
            foreach ($request->slides as $slide) {
                HeroSlide::where('id', $slide['id'])
                    ->update(['sort_order' => $slide['sort_order']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error reordering slides: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update order.'
            ], 500);
        }
    }
}
