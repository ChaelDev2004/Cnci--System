<?php

namespace App\Http\Controllers;

use App\Models\Pastor;
use App\Models\PastorImage;
use Illuminate\Http\Request;

class GalleryPageController extends Controller
{
    public function index(Request $request)
    {
        $pastorId = $request->query('pastor');

        $pastors = Pastor::query()
            ->whereHas('galleryImages')
            ->orderBy('name')
            ->get(['id', 'name', 'church']);

        $imagesQuery = PastorImage::with('pastor')
            ->orderBy('sort_order')
            ->orderByDesc('id');

        if ($pastorId) {
            $imagesQuery->where('pastor_id', $pastorId);
        }

        $images = $imagesQuery->get();

        return view('gallery', compact('images', 'pastors', 'pastorId'));
    }
}
