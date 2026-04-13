<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    /**
     * Handle the Category "updating" event.
     * This handles cascading deactivation ONLY.
     * Depth calculation is handled in the model's boot method.
     */
    public function updating(Category $category): void
    {
        if ($category->isDirty('is_active') && $category->is_active === false) {
            $this->deactivateChildren($category);
        }
        Cache::forget('homepage.featured.categories');
    }

    /**
     * Recursively deactivate all children
     */
    protected function deactivateChildren(Category $category): void
    {
        foreach ($category->children as $child) {
            if ($child->is_active) {
                $child->is_active = false;
                $child->saveQuietly();
                // Recursively deactivate grandchildren
                $this->deactivateChildren($child);
            }
        }
        Cache::forget('homepage.featured.categories');
    }
}
