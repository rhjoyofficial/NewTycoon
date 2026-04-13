<?php

namespace App\Http\Controllers\Admin;

use App\Models\Catalog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CatalogController extends Controller
{
    public function index()
    {
        $catalogs = Catalog::orderBy('sort_order')->latest()->paginate(10);
        return view('admin.catalogs.index', compact('catalogs'));
    }

    public function create()
    {
        return view('admin.catalogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'pdf_file' => 'required|mimes:pdf|max:20480',
            'thumbnail' => 'nullable|image'
        ]);

        $data = $request->only([
            'title',
            'company_name',
            'description',
            'is_active',
            'sort_order'
        ]);

        if ($request->hasFile('pdf_file')) {
            $data['pdf_file'] = $request->file('pdf_file')
                ->store('catalogs/pdfs', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('catalogs/thumbnails', 'public');
        }

        Catalog::create($data);

        flash('Catalog created successfully.', 'success');
        return redirect()->route('admin.catalogs.index');
    }

    public function edit(Catalog $catalog)
    {
        return view('admin.catalogs.edit', compact('catalog'));
    }

    public function update(Request $request, Catalog $catalog)
    {
        $request->validate([
            'title' => 'required',
            'pdf_file' => 'nullable|mimes:pdf|max:20480',
            'thumbnail' => 'nullable|image'
        ]);

        $data = $request->only([
            'title',
            'company_name',
            'description',
            'is_active',
            'sort_order'
        ]);

        if ($request->hasFile('pdf_file')) {
            Storage::disk('public')->delete($catalog->pdf_file);
            $data['pdf_file'] = $request->file('pdf_file')
                ->store('catalogs/pdfs', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($catalog->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('catalogs/thumbnails', 'public');
        }

        $catalog->update($data);

        flash('Catalog updated successfully.', 'success');
        return redirect()->route('admin.catalogs.index');
    }

    public function destroy(Catalog $catalog)
    {
        Storage::disk('public')->delete([
            $catalog->pdf_file,
            $catalog->thumbnail
        ]);

        $catalog->delete();
        flash('Catalog deleted successfully.', 'success');
        return redirect()->route('admin.catalogs.index');
    }
}
