<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /* ---------------------------------
     | Constants
     |---------------------------------*/
    public const MAX_DEPTH = 3; // Parent → Child → Sub-child

    protected $fillable = [
        'name_en',
        'name_bn',
        'description_en',
        'description_bn',
        'slug',
        'image',
        'parent_id',
        'order',
        'nav_order',
        'is_featured',
        'show_in_nav',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'depth',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'show_in_nav' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
        'nav_order' => 'integer',
        'depth' => 'integer',
    ];

    /* ---------------------------------
     | Boot
     |---------------------------------*/
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            // Auto-generate slug if empty
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name_en);
            }

            // Set Bengali name to English if empty
            if (empty($category->name_bn)) {
                $category->name_bn = $category->name_en;
            }

            // Calculate and set depth
            $category->depth = $category->calculateDepth();
        });

        static::updating(function ($category) {
            // Auto-update slug if name changes and slug is empty
            if ($category->isDirty('name_en') && empty($category->slug)) {
                $category->slug = Str::slug($category->name_en);
            }

            // Recalculate depth if parent changes
            if ($category->isDirty('parent_id')) {
                $category->depth = $category->calculateDepth();
            }
        });

        static::saved(function ($category) {
            // Update depths of all descendants when parent changes
            if ($category->wasChanged('parent_id')) {
                $category->updateDescendantDepths();
            }
        });
    }

    /* ---------------------------------
     | Relationships
     |---------------------------------*/
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->orderBy('nav_order')
            ->orderBy('order');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function ancestors()
    {
        return $this->parent()->with('ancestors');
    }

    /* ---------------------------------
     | Scopes
     |---------------------------------*/
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeShowInNav($query)
    {
        return $query->where('show_in_nav', true);
    }

    public function scopeWithActiveProducts($query)
    {
        return $query->whereHas('products', function ($q) {
            $q->active();
        });
    }

    public function scopeLeaf($query)
    {
        return $query->whereDoesntHave('children');
    }

    public function scopeByDepth($query, int $depth)
    {
        return $query->where('depth', $depth);
    }

    /**
     * Scope to get categories with all active parents
     */
    public function scopeActiveWithActiveParents($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('parent_id')
                    ->orWhereHas('parent', function ($parentQuery) {
                        $parentQuery->where('is_active', true)
                            ->where(function ($grandparentQuery) {
                                $grandparentQuery->whereNull('parent_id')
                                    ->orWhereHas('parent', function ($ggQuery) {
                                        $ggQuery->where('is_active', true);
                                    });
                            });
                    });
            });
    }

    /* ---------------------------------
     | Accessors
     |---------------------------------*/
    public function getUrlAttribute(): string
    {
        return route('categories.show', $this->slug);
    }

    public function getFullPathAttribute(): string
    {
        $path = collect([$this->name]);
        $parent = $this->parent;

        while ($parent) {
            $path->prepend($parent->name);
            $parent = $parent->parent;
        }

        return $path->implode(' > ');
    }

    public function getNameAttribute(): string
    {
        return app()->getLocale() === 'bn'
            ? ($this->name_bn ?: $this->name_en)
            : $this->name_en;
    }

    public function getDescriptionAttribute(): ?string
    {
        return app()->getLocale() === 'bn'
            ? ($this->description_bn ?: $this->description_en)
            : $this->description_en;
    }

    /* ---------------------------------
     | Helpers
     |---------------------------------*/
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    public function canHaveChildren(): bool
    {
        return $this->depth < self::MAX_DEPTH;
    }

    public function canHaveProducts(): bool
    {
        return !$this->hasChildren();
    }

    /**
     * Check if this category and all its parents are active
     * CRITICAL: Used by ActiveProductService
     */
    public function isFullyActive(): bool
    {
        // Check if current category is active
        if (!$this->is_active) {
            return false;
        }

        // If root category, it's fully active
        if (!$this->parent_id) {
            return true;
        }

        // Check all parents recursively
        $parent = $this->parent;
        while ($parent) {
            if (!$parent->is_active) {
                return false;
            }
            $parent = $parent->parent;
        }

        return true;
    }

    public function calculateDepth(): int
    {
        if (!$this->parent_id) {
            return 1; // Root level
        }

        $depth = 1;
        $parent = $this->parent;

        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }

        return $depth;
    }

    public function updateDescendantDepths(): void
    {
        foreach ($this->children as $child) {
            $child->depth = $child->calculateDepth();
            $child->saveQuietly();
            $child->updateDescendantDepths();
        }
    }

    public function getAllDescendantIds(): array
    {
        $ids = [];

        foreach ($this->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->getAllDescendantIds());
        }

        return $ids;
    }

    public function getAllCategoryIds(): array
    {
        return array_merge([$this->id], $this->getAllDescendantIds());
    }

    public function getProductsQuery(?string $search = null)
    {
        $categoryIds = $this->getAllCategoryIds();

        return Product::active()
            ->whereIn('category_id', $categoryIds)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->search($search)
                        ->orWhereHas('category', function ($q) use ($search) {
                            $q->where('name_en', 'LIKE', "%{$search}%")
                                ->orWhere('name_bn', 'LIKE', "%{$search}%");
                        });
                });
            });
    }

    public function getProductsCount(?string $search = null): int
    {
        return $this->getProductsQuery($search)->count();
    }

    public function getParentCategories()
    {
        $parents = collect();
        $parent = $this->parent;

        while ($parent) {
            $parents->prepend($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }

    public function getLeafDescendants()
    {
        $leaves = collect();

        if (!$this->hasChildren()) {
            $leaves->push($this);
        } else {
            foreach ($this->children as $child) {
                $leaves = $leaves->merge($child->getLeafDescendants());
            }
        }

        return $leaves;
    }

    public function isLeaf(): bool
    {
        return !$this->hasChildren();
    }

    public function isParentActive(): bool
    {
        if (!$this->parent_id) {
            return true; // Root categories have no parent
        }

        $parent = $this->parent;

        while ($parent) {
            if (!$parent->is_active) {
                return false;
            }
            $parent = $parent->parent;
        }

        return true;
    }



    /**
     *  OPTIMIZED: Get all category IDs (current + descendants) without recursion
     * This replaces the slow getAllCategoryIds() method
     */
    public function getAllCategoryIdsOptimized(): array
    {
        // If it's a leaf (depth 2), just return its own ID
        if ($this->depth === 2) {
            return [$this->id];
        }

        // Use raw query for maximum performance
        return DB::table('categories')
            ->where(function ($query) {
                $query->where('id', $this->id)
                    ->orWhere('parent_id', $this->id)
                    ->orWhereIn('parent_id', function ($subQuery) {
                        $subQuery->select('id')
                            ->from('categories')
                            ->where('parent_id', $this->id);
                    });
            })
            ->where('is_active', true)
            ->pluck('id')
            ->toArray();
    }

    /**
     *  OPTIMIZED: Check if category and all parents are active
     * Uses single query instead of recursive checks
     */
    public function isFullyActiveOptimized(): bool
    {
        // If no parent, just check self
        if (!$this->parent_id) {
            return $this->is_active;
        }

        // Check self and all parents in one query
        $activeCount = DB::table('categories')
            ->where(function ($query) {
                $query->where('id', $this->id);

                if ($this->parent_id) {
                    $query->orWhere('id', $this->parent_id);

                    // Check grandparent if exists
                    if ($this->depth === 2) {
                        $query->orWhereIn('id', function ($subQuery) {
                            $subQuery->select('parent_id')
                                ->from('categories')
                                ->where('id', $this->parent_id);
                        });
                    }
                }
            })
            ->where('is_active', true)
            ->count();

        // Should match the number of categories in the chain
        $expectedCount = $this->depth + 1;

        return $activeCount === $expectedCount;
    }

    /**
     *  OPTIMIZED: Get parent categories without N+1
     */
    public function getParentCategoriesOptimized()
    {
        if (!$this->parent_id) {
            return collect([]);
        }

        // Get all parents in one query
        $parents = DB::table('categories')
            ->select('id', 'name_en', 'name_bn', 'slug', 'parent_id', 'depth')
            ->where(function ($query) {
                $query->where('id', $this->parent_id);

                if ($this->depth === 2) {
                    $query->orWhereIn('id', function ($subQuery) {
                        $subQuery->select('parent_id')
                            ->from('categories')
                            ->where('id', $this->parent_id);
                    });
                }
            })
            ->orderBy('depth', 'asc')
            ->get();

        return $parents;
    }

    /**
     *  SCOPE: Get only active categories with proper indexing
     */
    public function scopeActiveOptimized($query)
    {
        return $query->where('is_active', true)
            ->select([
                'id',
                'name_en',
                'name_bn',
                'slug',
                'parent_id',
                'depth',
                'is_active',
                'is_featured',
                'order',
                'image'
            ]);
    }
}
