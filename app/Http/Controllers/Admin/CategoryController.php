<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display categories
     */
    public function index()
    {
        $categories = Category::select(['id', 'name_en', 'name_bn', 'slug', 'parent_id', 'depth', 'order', 'is_active', 'is_featured', 'image', 'created_at'])
            ->whereNull('parent_id')
            ->with([
                'children' => function ($query) {
                    $query->select('id', 'parent_id', 'name_en', 'name_bn', 'slug', 'depth', 'order', 'is_active', 'is_featured', 'image', 'created_at')
                        ->with([
                            'children' => function ($q) {
                                $q->select('id', 'parent_id', 'name_en', 'name_bn', 'slug', 'depth', 'order', 'is_active', 'is_featured', 'image', 'created_at')
                                    ->withCount('products');
                            }
                        ])->withCount('products');
                }
            ])->withCount('products')->orderBy('order')->orderBy('name_en')->paginate(8);

        $rootCategories = DB::table('categories')->whereNull('parent_id')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))->from('products')->whereColumn('products.category_id', 'categories.id');
            })->select('id', 'name_en', 'name_bn')->get();

        $stats = DB::table('categories')
            ->selectRaw('
                COUNT(*) as totalCategories,
                SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as activeCategories,
                SUM(CASE WHEN is_featured = 1 AND parent_id IS NULL THEN 1 ELSE 0 END) as featuredCategories,
                SUM(CASE WHEN depth = 2 THEN 1 ELSE 0 END) as leafCategories
            ')->first();

        $stats->totalProducts = Product::count();
        // dd($categories);
        return view('admin.categories.index', [
            'categories' => $categories,
            'rootCategories' => $rootCategories,
            'totalCategories' => $stats->totalCategories,
            'activeCategories' => $stats->activeCategories,
            'featuredCategories' => $stats->featuredCategories,
            'totalProducts' => $stats->totalProducts,
            'leafCategories' => $stats->leafCategories,
        ]);
    }

    /**
     * Show create form
     */
    public function create()
    {
        $parentCategories = DB::table('categories as c')
            ->leftJoin('products as p', 'c.id', '=', 'p.category_id')
            ->where('c.is_active', true)
            ->where('c.depth', '<', Category::MAX_DEPTH)
            ->whereNull('p.id') // No products
            ->select('c.id', 'c.name_en', 'c.name_bn', 'c.depth', 'c.parent_id')
            ->orderBy('c.depth')
            ->orderBy('c.name_en')
            ->get()
            ->map(function ($category) {
                $category->full_name = $this->getFullPath($category->id);
                return $category;
            });


        return view('admin.categories.create', [
            'parentCategories' => $parentCategories,
            'maxDepth' => Category::MAX_DEPTH,
        ]);
    }

    /**
     * Store category
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $data = $request->validated();

            // Handle image upload
            if ($request->hasFile('image')) {
                $filename = Str::slug($data['name_en']) . '-' . time() . '.' . $request->file('image')->extension();
                $data['image'] = $request->file('image')->storeAs('categories', $filename, 'public');
            }

            // Create the category
            $category = Category::create($data);

            flash(
                'Category created successfully!',
                'success',
                5000,
                'The category "' . $category->name_en . '" has been added at depth level ' . $category->depth . '.'
            );

            return redirect()->route('admin.categories.index');
        } catch (\Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all(),
            ]);

            flash('Category creation failed!', 'error', 8000, 'There was a problem creating the category. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show edit form
     */
    public function edit(Category $category)
    {
        $descendantIds = $this->getDescendantIdsOptimized($category->id);

        $parentCategories = DB::table('categories as c')
            ->leftJoin('products as p', 'c.id', '=', 'p.category_id')
            ->where('c.is_active', true)
            ->where('c.id', '!=', $category->id)
            ->whereNotIn('c.id', $descendantIds)
            ->whereNull('p.id')
            ->where('c.depth', '<', Category::MAX_DEPTH)
            ->select('c.id', 'c.name_en', 'c.name_bn', 'c.depth')
            ->orderBy('c.depth')
            ->orderBy('c.name_en')
            ->get()
            ->map(function ($category) {
                $category->full_name = $this->getFullPath($category->id);
                return $category;
            });

        $hasProducts = DB::table('products')->where('category_id', $category->id)->exists();

        $hasChildren = DB::table('categories')->where('parent_id', $category->id)->exists();

        return view('admin.categories.edit', [
            'category' => $category->load('children:id,parent_id,name_en,name_bn', 'products:id,name_en,category_id'),
            'parentCategories' => $parentCategories,
            'maxDepth' => Category::MAX_DEPTH,
            'hasProducts' => $hasProducts,
            'hasChildren' => $hasChildren,
        ]);
    }

    /**
     * Update category
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $data = $request->validated();

            // Handle image update
            if ($request->hasFile('image')) {
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }

                // Upload new image
                $filename = Str::slug($data['name_en']) . '-' . time() . '.' . $request->file('image')->extension();
                $data['image'] = $request->file('image')->storeAs('categories', $filename, 'public');
            }
            // If remove_image flag is true
            elseif ($request->has('remove_image') && $request->boolean('remove_image')) {
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
                $data['image'] = null;
            }

            // Update the category
            $category->update($data);

            $message = 'Category "' . $category->name_en . '" updated successfully';
            if ($category->wasChanged('parent_id')) {
                $message .= '. Descendant depths have been recalculated.';
            }

            flash('Category Updated!', 'success', 5000, $message);
            return redirect()->route('admin.categories.index');
        } catch (\Exception $e) {
            Log::error('Error updating category: ' . $e->getMessage(), [
                'exception' => $e,
                'category_id' => $category->id,
                'request' => $request->all(),
            ]);

            if ($e instanceof ValidationException) {
                throw $e;
            }

            flash('Update Failed!', 'error', 8000, 'An unexpected error occurred while updating the category. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Delete category
     */
    public function destroy(Category $category)
    {
        try {
            $hasChildren = DB::table('categories')->where('parent_id', $category->id)->exists();

            if ($hasChildren) {
                flash('Cannot Delete!', 'error', 8000, 'This category has subcategories. Please delete or reassign them first.');
                return redirect()->back();
            }

            // OPTIMIZED: Check products with raw query
            $productCount = DB::table('products')->where('category_id', $category->id)->count();

            if ($productCount > 0) {
                flash('Cannot Delete!', 'error', 8000, "This category has {$productCount} products assigned. Please reassign or delete them first.");
                return redirect()->back();
            }

            // Delete associated image
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();

            flash('Category Deleted!', 'success', 5000, 'The category has been successfully deleted.');

            return redirect()->route('admin.categories.index');
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage(), [
                'exception' => $e,
                'category_id' => $category->id,
            ]);

            flash('Deletion Failed!', 'error', 8000, 'An error occurred while deleting the category. Please try again.');

            return redirect()->back();
        }
    }

    /**
     * Toggle featured status
     */
    public function toggleFeature(Category $category)
    {
        $category->is_featured = !$category->is_featured;
        $category->save();
        Cache::forget('homepage.featured.categories');

        return response()->json([
            'success' => true,
            'is_featured' => $category->is_featured,
            'message' => $category->is_featured ? 'Category marked as featured.' : 'Category unmarked as featured.'
        ]);
    }

    /**
     * Change status
     */
    public function changeStatus(Request $request, Category $category)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        // OPTIMIZED: Check parent active status with raw query
        if ($request->is_active && $category->parent_id) {
            $parentActive = DB::table('categories')
                ->where('id', $category->parent_id)
                ->where('is_active', true)
                ->exists();

            if (!$parentActive) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot activate category when parent is inactive.',
                ], 422);
            }
        }

        $category->is_active = $request->is_active;
        $category->save();

        $message = $request->is_active
            ? 'Category activated successfully.'
            : 'Category and all its subcategories deactivated successfully.';

        return response()->json([
            'success' => true,
            'is_active' => $category->is_active,
            'message' => $message,
        ]);
    }

    /**
     * Bulk delete
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:categories,id'
        ]);

        try {
            // OPTIMIZED: Get categories with children/products count in one query
            $categoriesData = DB::table('categories as c')
                ->leftJoin('categories as children', 'c.id', '=', 'children.parent_id')
                ->leftJoin('products as p', 'c.id', '=', 'p.category_id')
                ->whereIn('c.id', $request->ids)
                ->select(
                    'c.id',
                    'c.image',
                    DB::raw('COUNT(DISTINCT children.id) as children_count'),
                    DB::raw('COUNT(DISTINCT p.id) as products_count')
                )
                ->groupBy('c.id', 'c.image')
                ->get();

            $count = 0;
            $skipped = 0;
            $deletedIds = [];

            foreach ($categoriesData as $data) {
                if ($data->children_count > 0 || $data->products_count > 0) {
                    $skipped++;
                    continue;
                }

                // Delete image if exists
                if ($data->image) {
                    Storage::disk('public')->delete($data->image);
                }

                $deletedIds[] = $data->id;
                $count++;
            }

            // OPTIMIZED: Bulk delete
            if (!empty($deletedIds)) {
                DB::table('categories')->whereIn('id', $deletedIds)->delete();
            }

            $message = "{$count} categories deleted successfully.";
            if ($skipped > 0) {
                $message .= " {$skipped} categories skipped (have children or products).";
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'count' => $count,
                'skipped' => $skipped,
            ]);
        } catch (\Exception $e) {
            Log::error('Bulk delete error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete categories.'
            ], 500);
        }
    }

    /**
     * Bulk activate
     */
    public function bulkActivate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:categories,id'
        ]);

        try {
            $categories = Category::whereIn('id', $request->ids)
                ->select('id', 'parent_id')
                ->get();

            $count = 0;
            $skipped = 0;

            foreach ($categories as $category) {
                // OPTIMIZED: Check parent with raw query
                if ($category->parent_id) {
                    $parentActive = DB::table('categories')
                        ->where('id', $category->parent_id)
                        ->where('is_active', true)
                        ->exists();

                    if (!$parentActive) {
                        $skipped++;
                        continue;
                    }
                }

                DB::table('categories')
                    ->where('id', $category->id)
                    ->update(['is_active' => true]);
                $count++;
            }

            $message = "{$count} categories activated.";
            if ($skipped > 0) {
                $message .= " {$skipped} categories skipped (parent inactive).";
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'count' => $count,
                'skipped' => $skipped,
            ]);
        } catch (\Exception $e) {
            Log::error('Bulk activate error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to activate categories.'
            ], 500);
        }
    }

    /**
     * Bulk deactivate
     */
    public function bulkDeactivate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:categories,id'
        ]);

        try {
            // OPTIMIZED: Bulk update
            $count = DB::table('categories')
                ->whereIn('id', $request->ids)
                ->update(['is_active' => false]);

            return response()->json([
                'success' => true,
                'message' => "{$count} categories and their descendants deactivated.",
                'count' => $count
            ]);
        } catch (\Exception $e) {
            Log::error('Bulk deactivate error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to deactivate categories.'
            ], 500);
        }
    }

    /**
     * Reorder categories
     */
    public function reorder(Request $request, Category $category)
    {
        $request->validate([
            'direction' => 'required|in:up,down'
        ]);

        try {
            // OPTIMIZED: Use raw query for sibling lookup
            if ($request->direction === 'up') {
                $sibling = DB::table('categories')
                    ->where('parent_id', $category->parent_id ?: null)
                    ->where('order', '<', $category->order)
                    ->orderBy('order', 'desc')
                    ->first();
            } else {
                $sibling = DB::table('categories')
                    ->where('parent_id', $category->parent_id ?: null)
                    ->where('order', '>', $category->order)
                    ->orderBy('order', 'asc')
                    ->first();
            }

            if ($sibling) {
                // Swap orders
                $tempOrder = $category->order;

                DB::table('categories')->where('id', $category->id)
                    ->update(['order' => $sibling->order]);

                DB::table('categories')->where('id', $sibling->id)
                    ->update(['order' => $tempOrder]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Category order updated.'
            ]);
        } catch (\Exception $e) {
            Log::error('Reorder error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to reorder category.'
            ], 500);
        }
    }

    /**
     * Get eligible parent categories (AJAX)
     */
    public function getEligibleParents(Request $request)
    {
        $categoryId = $request->input('category_id');

        $query = DB::table('categories as c')
            ->leftJoin('products as p', 'c.id', '=', 'p.category_id')
            ->where('c.is_active', true)
            ->where('c.depth', '<', Category::MAX_DEPTH)
            ->whereNull('p.id');

        if ($categoryId) {
            $descendantIds = $this->getDescendantIdsOptimized($categoryId);
            $query->where('c.id', '!=', $categoryId)
                ->whereNotIn('c.id', $descendantIds);
        }

        $categories = $query
            ->select('c.id', 'c.name_en', 'c.name_bn', 'c.depth')
            ->orderBy('c.depth')
            ->orderBy('c.name_en')
            ->get()
            ->map(function ($cat) {
                return [
                    'id' => $cat->id,
                    'name' => $this->getFullPath($cat->id),
                    'depth' => $cat->depth,
                ];
            });

        return response()->json($categories);
    }

    /**
     * OPTIMIZED: Get descendant IDs with raw query
     */
    private function getDescendantIdsOptimized(int $categoryId): array
    {
        return DB::table('categories')
            ->where(function ($query) use ($categoryId) {
                $query->where('parent_id', $categoryId)
                    ->orWhereIn('parent_id', function ($subQuery) use ($categoryId) {
                        $subQuery->select('id')
                            ->from('categories')
                            ->where('parent_id', $categoryId);
                    });
            })
            ->pluck('id')
            ->toArray();
    }

    /**
     * OPTIMIZED: Get full category path
     */
    private function getFullPath(int $categoryId): string
    {
        $category = DB::table('categories')->where('id', $categoryId)->first();
        if (!$category) return '';

        $path = [$category->name_en];

        if ($category->parent_id) {
            $parent = DB::table('categories')->where('id', $category->parent_id)->first();
            if ($parent) {
                array_unshift($path, $parent->name_en);

                if ($parent->parent_id) {
                    $grandparent = DB::table('categories')->where('id', $parent->parent_id)->first();
                    if ($grandparent) {
                        array_unshift($path, $grandparent->name_en);
                    }
                }
            }
        }

        return implode(' > ', $path);
    }
}
