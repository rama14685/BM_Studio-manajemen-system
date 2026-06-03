<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarouselItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCarouselController extends Controller
{
    /**
     * Display a listing of carousel items.
     */
    public function index()
    {
        $carouselItems = CarouselItem::all();
        return view('admin.carousel.index', compact('carouselItems'));
    }

    /**
     * Store a newly created carousel item.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $imagePath = '';
        if ($request->hasFile('image')) {
            // Store locally in public/images
            $file = $request->file('image');
            $filename = 'studio_room_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $imagePath = '/images/' . $filename;
        }

        CarouselItem::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.carousel.index')->with('success', 'Slide carousel baru berhasil ditambahkan.');
    }

    /**
     * Update the specified carousel item.
     */
    public function update(Request $request, $id)
    {
        $carouselItem = CarouselItem::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            // Delete old file if dynamic
            if (str_starts_with($carouselItem->image_path, '/images/studio_room_') && file_exists(public_path($carouselItem->image_path))) {
                @unlink(public_path($carouselItem->image_path));
            }

            $file = $request->file('image');
            $filename = 'studio_room_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $data['image_path'] = '/images/' . $filename;
        }

        $carouselItem->update($data);

        return redirect()->route('admin.carousel.index')->with('success', 'Slide carousel berhasil diperbarui.');
    }

    /**
     * Remove the specified carousel item.
     */
    public function destroy($id)
    {
        $carouselItem = CarouselItem::findOrFail($id);

        // Delete image file if dynamic
        if (str_starts_with($carouselItem->image_path, '/images/studio_room_') && file_exists(public_path($carouselItem->image_path))) {
            @unlink(public_path($carouselItem->image_path));
        }

        $carouselItem->delete();

        return redirect()->route('admin.carousel.index')->with('success', 'Slide carousel berhasil dihapus.');
    }
}
