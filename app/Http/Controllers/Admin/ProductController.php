<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display products
     */
    public function index(Request $request)
    {
        $products = Product::select([
            'id',
            'name_en',
            'name_bn',
            'slug',
            'sku',
            'price',
            'compare_price',
            'discount_percentage',
            'quantity',
            'stock_status',
            'status',
            'category_id',
            'is_featured',
            'is_new',
            'featured_images',
            'created_at'
        ])
            ->with('category:id,name_en,name_bn,slug')
            ->when($request->search, function ($q) use ($request) {
                $search = $request->search;
                $q->where(function ($query) use ($search) {
                    $query->where('name_en', 'like', "%{$search}%")
                        ->orWhere('name_bn', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when(
                $request->status && $request->status !== 'all',
                fn($q) => $q->where('status', $request->status)
            )
            ->when(
                $request->category_id && $request->category_id !== 'all',
                fn($q) => $q->where('category_id', $request->category_id)
            )
            ->latest()
            ->paginate(20);

        // FIXED: Get only LEAF categories (no children)
        $categories = $this->getLeafCategoriesOptimized();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show create form
     * FIXED: Get only LEAF categories (categories with NO children)
     */
    public function create()
    {
        // FIXED: Get only categories that have NO children (leaf categories)
        $categories = $this->getLeafCategoriesOptimized();

        if ($categories->isEmpty()) {
            flash(
                'No Available Categories',
                'warning',
                8000,
                'Please create leaf categories (categories without subcategories) before adding products.'
            );
        }

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store product
     */
    public function store(StoreProductRequest $request)
    {
        try {
            DB::beginTransaction();

            $product = Product::create(
                array_merge(
                    $request->validated(),
                    [
                        'vendor_id' => Auth::id(),
                        'featured_images' => $this->storeImages(
                            $request->file('featured_images'),
                            'products/featured',
                            2,
                            [Product::DEFAULT_FEATURED_IMAGE]
                        ),
                        'gallery_images' => $this->storeImages(
                            $request->file('gallery_images'),
                            'products/gallery',
                            5
                        ),
                    ]
                )
            );

            DB::commit();

            flash('Product Created!', 'success', 5000, "Product '{$product->name_en}' created successfully.");
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating product: ' . $e->getMessage());

            flash('Creation Failed!', 'error', 8000, 'Failed to create product. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show edit form
     * FIXED: Get only LEAF categories
     */
    public function edit(Product $product)
    {
        // FIXED: Get only leaf categories
        $categories = $this->getLeafCategoriesOptimized();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update product
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            DB::beginTransaction();

            // ---------- FEATURED IMAGES ----------
            $featured = $request->input('existing_featured_images', $product->featured_images ?? []);

            // Remove selected
            if ($request->filled('remove_featured_images')) {
                foreach ($request->remove_featured_images as $path) {
                    if ($path !== Product::DEFAULT_FEATURED_IMAGE) {
                        Storage::disk('public')->delete($path);
                    }
                    $featured = array_values(array_diff($featured, [$path]));
                }
            }

            // Add new uploads
            if ($request->hasFile('featured_images')) {
                foreach ($request->file('featured_images') as $image) {
                    if (count($featured) >= 2) break;
                    $featured[] = $image->store('products/featured', 'public');
                }
            }

            // ---------- GALLERY IMAGES ----------
            $gallery = $request->input('existing_gallery_images', $product->gallery_images ?? []);

            if ($request->filled('remove_gallery_images')) {
                foreach ($request->remove_gallery_images as $path) {
                    Storage::disk('public')->delete($path);
                    $gallery = array_values(array_diff($gallery, [$path]));
                }
            }

            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    if (count($gallery) >= 5) break;
                    $gallery[] = $image->store('products/gallery', 'public');
                }
            }

            // ---------- UPDATE PRODUCT ----------
            $product->update(array_merge(
                $request->validated(),
                [
                    'featured_images' => $featured,
                    'gallery_images'  => $gallery,
                ]
            ));

            DB::commit();

            flash('Product Updated!', 'success', 5000, "Product '{$product->name_en}' updated successfully.");
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating product: ' . $e->getMessage());

            flash('Update Failed!', 'error', 8000, 'Failed to update product. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show product details
     */
    public function show($slug)
    {
        // OPTIMIZED: Load with specific columns
        $product = Product::where('slug', $slug)
            ->with([
                'category:id,name_en,name_bn,slug',
                'reviews' => function ($query) {
                    $query->latest()
                        ->limit(10)
                        ->select('id', 'product_id', 'user_id', 'rating', 'comment', 'is_approved', 'created_at');
                },
                'reviews.user:id,name,email,avatar',
            ])
            ->firstOrFail();

        // OPTIMIZED: Get order items with raw query
        $recentOrders = DB::table('order_items as oi')
            ->join('orders as o', 'oi.order_id', '=', 'o.id')
            ->where('oi.product_id', $product->id)
            ->select('o.order_number', 'o.created_at', 'oi.quantity', 'oi.total_price', 'o.status')
            ->orderBy('o.created_at', 'desc')
            ->limit(10)
            ->get();

        // OPTIMIZED: Get wishlists with raw query
        $wishlists = DB::table('wishlists as w')
            ->join('users as u', 'w.user_id', '=', 'u.id')
            ->where('w.product_id', $product->id)
            ->select('u.name', 'u.email', 'w.created_at')
            ->orderBy('w.created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.products.show', compact('product', 'recentOrders', 'wishlists'));
    }

    /**
     * Delete product
     */
    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            // Delete images
            $this->deleteImages($product->featured_images);
            $this->deleteImages($product->gallery_images);

            $product->delete();

            DB::commit();

            flash('Product Deleted!', 'success', 5000, 'Product deleted successfully.');
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting product: ' . $e->getMessage());

            flash('Deletion Failed!', 'error', 8000, 'Failed to delete product. Please try again.');
            return redirect()->back();
        }
    }

    /**
     * Bulk delete products
     */
    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id',
        ]);

        try {
            DB::beginTransaction();

            $products = Product::whereIn('id', $request->ids)
                ->select('id', 'featured_images', 'gallery_images')
                ->get();

            foreach ($products as $product) {
                $this->deleteImages($product->featured_images);
                $this->deleteImages($product->gallery_images);
            }

            Product::whereIn('id', $request->ids)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => count($request->ids) . ' products deleted successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk delete error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete products.'
            ], 500);
        }
    }

    /**
     * Update product status
     */
    public function updateStatus(Request $request, Product $product)
    {
        $request->validate([
            'status' => 'required|in:draft,active,inactive,archived',
        ]);

        try {
            $product->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Product status updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status.'
            ], 500);
        }
    }

    /**
     * Update stock status
     */
    public function updateStockStatus(Request $request, Product $product)
    {
        $request->validate([
            'stock_status' => 'required|in:in_stock,out_of_stock,backorder',
        ]);

        try {
            $product->update(['stock_status' => $request->stock_status]);

            return response()->json([
                'success' => true,
                'message' => 'Stock status updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update stock status.'
            ], 500);
        }
    }

    /**
     * Toggle featured status
     */
    public function updateFeaturedStatus(Request $request, Product $product)
    {
        try {
            $product->update(['is_featured' => !$product->is_featured]);

            return response()->json([
                'success' => true,
                'message' => 'Featured status updated successfully!',
                'is_featured' => $product->is_featured
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update featured status.'
            ], 500);
        }
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate,archive',
            'selected_ids' => 'required|array'
        ]);

        try {
            DB::beginTransaction();

            switch ($request->action) {
                case 'delete':
                    $products = Product::whereIn('id', $request->selected_ids)
                        ->select('id', 'featured_images', 'gallery_images')
                        ->get();

                    foreach ($products as $product) {
                        $this->deleteImages($product->featured_images);
                        $this->deleteImages($product->gallery_images);
                    }

                    Product::whereIn('id', $request->selected_ids)->delete();
                    $message = 'Selected products deleted successfully.';
                    break;

                case 'activate':
                    DB::table('products')
                        ->whereIn('id', $request->selected_ids)
                        ->update(['status' => 'active']);
                    $message = 'Selected products activated successfully.';
                    break;

                case 'deactivate':
                    DB::table('products')
                        ->whereIn('id', $request->selected_ids)
                        ->update(['status' => 'inactive']);
                    $message = 'Selected products deactivated successfully.';
                    break;

                case 'archive':
                    DB::table('products')
                        ->whereIn('id', $request->selected_ids)
                        ->update(['status' => 'archived']);
                    $message = 'Selected products archived successfully.';
                    break;
            }

            DB::commit();

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk action error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Bulk action failed. Please try again.');
        }
    }

    /**
     * Check SKU availability
     */
    public function checkSku(Request $request)
    {
        $request->validate([
            'sku' => 'required|string',
            'product_id' => 'nullable|exists:products,id',
        ]);

        $exists = DB::table('products')
            ->where('sku', $request->sku)
            ->when($request->product_id, function ($q) use ($request) {
                $q->where('id', '!=', $request->product_id);
            })
            ->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'SKU already taken' : 'SKU is available'
        ]);
    }

    /**
     * Get available categories for product (AJAX)
     */
    public function getAvailableCategories()
    {
        $categories = $this->getLeafCategoriesOptimized();

        return response()->json($categories);
    }

    /* -----------------------------------------------------------------
     | Helper Methods
     |------------------------------------------------------------------*/

    /**
     * FIXED: Get only LEAF categories (categories with NO children)
     * This is the key fix - use LEFT JOIN to check for children
     */
    private function getLeafCategoriesOptimized()
    {
        return DB::table('categories as c')
            ->leftJoin('categories as children', 'c.id', '=', 'children.parent_id')
            ->where('c.is_active', true)
            ->select(
                'c.id',
                'c.name_en',
                'c.name_bn',
                'c.depth',
                'c.parent_id',
                DB::raw('COUNT(children.id) as children_count')
            )
            ->groupBy('c.id', 'c.name_en', 'c.name_bn', 'c.depth', 'c.parent_id')
            ->having('children_count', '=', 0)  // CRITICAL: Only categories with NO children
            ->orderBy('c.name_en')
            ->get()
            ->map(function ($category) {
                $category->full_name = $this->getCategoryFullPath($category->id);
                return $category;
            });
    }

    /**
     * Store images
     */
    protected function storeImages(
        ?array $files,
        string $directory,
        int $limit,
        array $fallback = []
    ): array {
        if (empty($files)) {
            return $fallback;
        }

        $paths = [];

        foreach ($files as $file) {
            if (count($paths) >= $limit) break;
            $paths[] = $file->store($directory, 'public');
        }

        return $paths;
    }

    /**
     * Delete images
     */
    protected function deleteImages(?array $images): void
    {
        foreach ($images ?? [] as $image) {
            if ($image !== Product::DEFAULT_FEATURED_IMAGE) {
                Storage::disk('public')->delete($image);
            }
        }
    }

    /**
     * Get category full path
     */
    private function getCategoryFullPath(int $categoryId): string
    {
        $category = DB::table('categories as c1')
            ->leftJoin('categories as c2', 'c1.parent_id', '=', 'c2.id')
            ->leftJoin('categories as c3', 'c2.parent_id', '=', 'c3.id')
            ->where('c1.id', $categoryId)
            ->select('c1.name_en as name', 'c2.name_en as parent_name', 'c3.name_en as grandparent_name')
            ->first();

        if (!$category) return '';

        $path = array_filter([
            $category->grandparent_name,
            $category->parent_name,
            $category->name
        ]);

        return implode(' > ', $path);
    }


    public function changeStatus(Request $request, Product $product)
    {
        $product->status = $request->input('status');
        $product->save();

        Cache::forget('homepage.featured.products');

        return response()->json([
            'success' => true,
            'status' => $product->status
        ]);
    }
}
