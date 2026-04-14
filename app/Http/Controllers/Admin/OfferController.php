<?php

namespace App\Http\Controllers\Admin;

use App\Models\Offer;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::withCount('products')
            ->orderBy('order')
            ->orderByDesc('created_at')
            ->paginate(20);

        $activeCount    = Offer::where('status', 'active')->count();
        $scheduledCount = Offer::where('status', 'scheduled')->count();
        $totalViews     = (int) Offer::sum('view_count');

        return view('admin.offers.index', compact('offers', 'activeCount', 'scheduledCount', 'totalViews'));
    }

    public function create()
    {
        $categories = Category::active()->whereNull('parent_id')->with('children')->get();
        $products = Product::active()->limit(100)->get();

        return view('admin.offers.create', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en'          => 'required|string|max:255',
            'title_bn'          => 'nullable|string|max:255',
            'subtitle_en'       => 'nullable|string|max:500',
            'subtitle_bn'       => 'nullable|string|max:500',
            'short_des_en'      => 'nullable|string|max:500',
            'short_des_bn'      => 'nullable|string|max:500',
            'main_banner_image' => 'nullable|image|max:5120',
            'timer_enabled'     => 'boolean',
            'timer_end_date'    => 'nullable|date|after:now',
            'view_all_link'     => 'nullable|string|max:255',
            'view_all_text'     => 'nullable|string|max:50',
            'product_source'    => 'required|in:manual,discount,category,tag',
            'source_config'     => 'nullable|array',
            'product_limit'     => 'required|integer|min:1|max:100',
            'status'            => 'required|in:draft,active,inactive,scheduled',
            'start_date'        => 'nullable|date',
            'end_date'          => 'nullable|date|after:start_date',
            'order'             => 'nullable|integer',
            'products'          => 'nullable|array',
            'products.*'        => 'exists:products,id',
        ]);

        if ($request->hasFile('main_banner_image')) {
            $validated['main_banner_image'] = $request->file('main_banner_image')
                ->store('offers', 'public');
        }

        // Set defaults
        $validated['timer_enabled'] = $request->boolean('timer_enabled');
        $validated['order'] = $validated['order'] ?? Offer::max('order') + 1;
        $validated['view_all_text'] = $validated['view_all_text'] ?? 'View All';

        $offer = Offer::create($validated);

        // Attach products if manual
        if ($validated['product_source'] === 'manual' && !empty($validated['products'])) {
            foreach ($validated['products'] as $index => $productId) {
                $offer->products()->attach($productId, ['order' => $index]);
            }
        }
        flash('Offer created successfully.', 'success');
        return redirect()->route('admin.offers.index');
    }

    public function edit(Offer $offer)
    {
        $categories = Category::active()->whereNull('parent_id')->with('children')->get();
        $products = Product::active()->limit(100)->get();
        $selectedProducts = $offer->products->pluck('id')->toArray();

        return view('admin.offers.edit', compact('offer', 'categories', 'products', 'selectedProducts'));
    }

    public function update(Request $request, Offer $offer)
    {
        $validated = $request->validate([
            'title_en'          => 'required|string|max:255',
            'title_bn'          => 'nullable|string|max:255',
            'subtitle_en'       => 'nullable|string|max:500',
            'subtitle_bn'       => 'nullable|string|max:500',
            'short_des_en'      => 'nullable|string|max:500',
            'short_des_bn'      => 'nullable|string|max:500',
            'main_banner_image' => 'nullable|image|max:5120',
            'timer_enabled'     => 'boolean',
            'timer_end_date'    => 'nullable|date',
            'view_all_link'     => 'nullable|string|max:255',
            'view_all_text'     => 'nullable|string|max:50',
            'product_source'    => 'required|in:manual,discount,category,tag',
            'source_config'     => 'nullable|array',
            'product_limit'     => 'required|integer|min:1|max:100',
            'status'            => 'required|in:draft,active,inactive,scheduled',
            'start_date'        => 'nullable|date',
            'end_date'          => 'nullable|date|after:start_date',
            'order'             => 'nullable|integer',
            'products'          => 'nullable|array',
            'products.*'        => 'exists:products,id',
        ]);

        if ($request->hasFile('main_banner_image')) {
            if ($offer->main_banner_image) {
                Storage::disk('public')->delete($offer->main_banner_image);
            }
            $validated['main_banner_image'] = $request->file('main_banner_image')
                ->store('offers/banners', 'public');
        }

        $validated['timer_enabled'] = $request->boolean('timer_enabled');

        $offer->update($validated);

        // Sync products if manual
        if ($validated['product_source'] === 'manual') {
            if (!empty($validated['products'])) {
                $syncData = [];
                foreach ($validated['products'] as $index => $productId) {
                    $syncData[$productId] = ['order' => $index];
                }
                $offer->products()->sync($syncData);
            } else {
                $offer->products()->detach();
            }
        } else {
            $offer->products()->detach();
        }

        flash('Offer updated successfully.', 'success');
        return redirect()->route('admin.offers.index');
    }

    public function destroy(Offer $offer)
    {
        if ($offer->main_banner_image) {
            Storage::disk('public')->delete($offer->main_banner_image);
        }

        $offer->delete();
        flash('Offer deleted successfully.', 'success');
        return redirect()->route('admin.offers.index');
    }

    public function toggleStatus(Offer $offer)
    {
        $offer->status = $offer->status === 'active' ? 'inactive' : 'active';
        $offer->save();

        $isActive = $offer->status === 'active';

        flash(
            "Offer " . ($isActive ? 'activated' : 'deactivated') . " successfully.",
            $isActive ? 'success' : 'warning'
        );

        return redirect()->route('admin.offers.index');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'offers' => 'required|array',
            'offers.*.id' => 'required|exists:offers,id',
            'offers.*.order' => 'required|integer',
        ]);

        foreach ($request->offers as $offerData) {
            Offer::where('id', $offerData['id'])->update(['order' => $offerData['order']]);
        }

        return response()->json(['success' => true]);
    }
}
