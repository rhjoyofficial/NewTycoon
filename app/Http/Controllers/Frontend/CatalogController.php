<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CatalogController extends Controller
{
    public function index()
    {
        $catalogs = Catalog::where('is_active', true)->orderBy('sort_order')->latest()->paginate(12);
        // dd($catalogs);
        return view('frontend.pages.catalogs', compact('catalogs'));
    }

    public function view(Catalog $catalog)
    {
        abort_unless(
            Storage::disk('public')->exists($catalog->pdf_file),
            404
        );

        return response()->stream(function () use ($catalog) {
            echo Storage::disk('public')->get($catalog->pdf_file);
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . Str::slug($catalog->title) . '.pdf"',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
