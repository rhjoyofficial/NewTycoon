<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdBannerRequest;
use App\Http\Requests\Admin\UpdateAdBannerRequest;
use App\Models\AdBanner;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdBannerController extends Controller
{
    /**
     * Display a listing of the ad banners.
     */
    public function index()
    {
        $banners = AdBanner::orderBy('order')->get();
        return view('admin.ad-banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new ad banner.
     */
    public function create()
    {
        return view('admin.ad-banners.create');
    }

    /**
     * Store a newly created ad banner in storage.
     */
    public function store(StoreAdBannerRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('images')) {
                $paths = [];
                foreach ($request->file('images') as $image) {
                    $paths[] = $image->store('ads-banner', 'public');
                }
                $data['images'] = $paths;
            }

            AdBanner::create($data);

            flash('Banner created successfully.', 'success');
            return redirect()->route('admin.content.ad-banners.index');
        } catch (\Exception $e) {
            // Optional: Delete uploaded images if DB create fails
            if (isset($paths)) {
                foreach ($paths as $path) {
                    Storage::disk('public')->delete($path);
                }
            }
            Log::error("AdBanner Store Error: " . $e->getMessage());
            flash('Something went wrong while creating the banner.', 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified ad banner.
     */
    public function edit(AdBanner $adBanner)
    {
        return view('admin.ad-banners.edit', compact('adBanner'));
    }

    /**
     * Update the specified ad banner in storage.
     */
    public function update(UpdateAdBannerRequest $request, AdBanner $adBanner)
    {
        try {
            $data = $request->validated();
            $oldImages = $adBanner->images; // Keep reference to delete later

            if ($request->hasFile('images')) {
                $paths = [];
                foreach ($request->file('images') as $image) {
                    $paths[] = $image->store('ads-banner', 'public');
                }
                $data['images'] = $paths;
            } else {
                unset($data['images']);
            }

            $adBanner->update($data);

            // Only delete old images if the update was successful and new ones were uploaded
            if ($request->hasFile('images') && is_array($oldImages)) {
                foreach ($oldImages as $oldPath) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            flash('Banner updated successfully.', 'success');
            return redirect()->route('admin.content.ad-banners.index');
        } catch (\Exception $e) {
            // Cleanup: If DB fails, delete the new images we just uploaded
            if (isset($paths)) {
                foreach ($paths as $path) {
                    Storage::disk('public')->delete($path);
                }
            }
            Log::error("AdBanner Update Error: " . $e->getMessage());
            flash('Update failed. Please try again.', 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified ad banner from storage.
     */
    public function destroy(AdBanner $adBanner)
    {
        try {
            // Delete associated images
            if (is_array($adBanner->images)) {
                foreach ($adBanner->images as $path) {
                    Storage::disk('public')->delete($path);
                }
            }

            $adBanner->delete();

            flash('Banner deleted successfully.', 'success');
            return redirect()->route('admin.content.ad-banners.index');
        } catch (\Exception $e) {
            Log::error("AdBanner Delete Error: " . $e->getMessage());
            flash('Failed to delete banner. It might be connected to other data.', 'error');
            return redirect()->back();
        }
    }
}
