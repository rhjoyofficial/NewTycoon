<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterColumn;
use App\Models\FooterLink;
use App\Models\FooterSetting;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function index()
    {
        $settings = FooterSetting::first();
        $columns  = FooterColumn::orderBy('sort_order')->with('links')->get();

        return view('admin.footer.index', compact('settings', 'columns'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'brand_name'              => 'required|string|max:255',
            'brand_description_en'    => 'nullable|string|max:1000',
            'brand_description_bn'    => 'nullable|string|max:1000',
            'address_en'              => 'nullable|string|max:500',
            'address_bn'              => 'nullable|string|max:500',
            'contact_info'            => 'nullable|array',
            'contact_info.hotline_1'  => 'nullable|string|max:30',
            'contact_info.hotline_2'  => 'nullable|string|max:30',
            'contact_info.email_1'    => 'nullable|email|max:255',
            'contact_info.email_2'    => 'nullable|email|max:255',
            'social_links'            => 'nullable|array',
            'social_links.facebook'   => 'nullable|string|max:500',
            'social_links.twitter'    => 'nullable|string|max:500',
            'social_links.instagram'  => 'nullable|string|max:500',
            'social_links.linkedin'   => 'nullable|string|max:500',
            'payment_methods'         => 'nullable|array',
            'payment_methods.*'       => 'nullable|string|max:500',
        ]);

        // Remove empty payment method entries
        if (isset($validated['payment_methods'])) {
            $validated['payment_methods'] = array_values(
                array_filter($validated['payment_methods'], fn($v) => !empty(trim($v)))
            );
        }

        FooterSetting::updateOrCreate([], $validated);

        flash('Footer settings updated.', 'success');
        return redirect()->route('admin.footer.index');
    }

    // ── Columns ──────────────────────────────────────────────────────────────

    public function storeColumn(Request $request)
    {
        $validated = $request->validate([
            'title_en'   => 'required|string|max:255',
            'title_bn'   => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? (FooterColumn::max('sort_order') + 1);
        $validated['is_active']  = true;

        FooterColumn::create($validated);

        flash('Column added.', 'success');
        return redirect()->route('admin.footer.index');
    }

    public function updateColumn(Request $request, FooterColumn $column)
    {
        $validated = $request->validate([
            'title_en'   => 'required|string|max:255',
            'title_bn'   => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $column->update($validated);

        flash('Column updated.', 'success');
        return redirect()->route('admin.footer.index');
    }

    public function destroyColumn(FooterColumn $column)
    {
        $column->links()->delete();
        $column->delete();

        flash('Column deleted.', 'success');
        return redirect()->route('admin.footer.index');
    }

    // ── Links ─────────────────────────────────────────────────────────────────

    public function storeLink(Request $request, FooterColumn $column)
    {
        $validated = $request->validate([
            'title_en'   => 'required|string|max:255',
            'title_bn'   => 'nullable|string|max:255',
            'url'        => 'required|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['footer_column_id'] = $column->id;
        $validated['sort_order']       = $validated['sort_order']
            ?? (FooterLink::where('footer_column_id', $column->id)->max('sort_order') + 1);
        $validated['is_active']        = true;

        FooterLink::create($validated);

        flash('Link added.', 'success');
        return redirect()->route('admin.footer.index');
    }

    public function updateLink(Request $request, FooterLink $link)
    {
        $validated = $request->validate([
            'title_en'   => 'required|string|max:255',
            'title_bn'   => 'nullable|string|max:255',
            'url'        => 'required|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $link->update($validated);

        flash('Link updated.', 'success');
        return redirect()->route('admin.footer.index');
    }

    public function destroyLink(FooterLink $link)
    {
        $link->delete();

        flash('Link deleted.', 'success');
        return redirect()->route('admin.footer.index');
    }
}
