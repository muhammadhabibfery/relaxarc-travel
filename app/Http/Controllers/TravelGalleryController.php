<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TravelGallery;
use App\Models\TravelPackage;
use Intervention\Image\Facades\Image;
use App\Http\Requests\TravelGalleryRequest;
use Illuminate\Support\Facades\Storage;

class TravelGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $travelPackages = TravelPackage::select('id', 'title')
            ->with(['travelGalleries'])
            ->where('title', 'LIKE', "%$request->keyword%")
            ->groupBy('title')
            ->latest()
            ->paginate(10);

        return view('pages.backend.travel-galleries.index', compact('travelPackages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $travelPackages = TravelPackage::select('id', 'title')
            ->latest()
            ->get();

        return view('pages.backend.travel-galleries.create', compact('travelPackages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TravelGalleryRequest $request)
    {
        $data = [
            'travel_package_id' => $request->validated()['travel_package'],
            'name' => $this->createImage($request),
            'slug' => $this->getSlug(),
            'uploaded_by' => auth()->id()
        ];

        TravelGallery::create($data);

        return redirect()->route('travel-galleries.index')
            ->with('status', trans('status.create_new_travel_gallery'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TravelGallery  $travelGallery
     * @return \Illuminate\Http\Response
     */
    public function show(TravelGallery $travelGallery)
    {
        return view('pages.backend.travel-galleries.detail', compact('travelGallery'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TravelGallery  $travelGallery
     * @return \Illuminate\Http\Response
     */
    public function edit(TravelGallery $travelGallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TravelGallery  $travelGallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TravelGallery $travelGallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TravelGallery  $travelGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(TravelGallery $travelGallery)
    {
        $travelGallery->update(['deleted_by' => auth()->id()]);

        $name = $travelGallery->name;
        $this->deleteImage($name);
        $travelGallery->delete();

        return redirect()->route('travel-galleries.index')
            ->with('status', trans('status.delete_travel_gallery', ['travelGallery' => $name]));
    }

    private function getSlug()
    {
        return Str::lower(Str::random(20));
    }

    private function createImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $fileName = $this->getFileName($request->file('image')->getClientOriginalName());

            $path = $this->cekDirectory($fileName);

            Image::make($request->file('image'))
                ->resize(1024, 683)
                ->save($path['pathImage']);

            Image::make($request->file('image'))
                ->resize(400, 267)
                ->save($path['pathThumbnail']);

            return $fileName;
        }
    }

    private function getFileName($name)
    {
        $fileName = explode('.', $name);
        $fileName = head($fileName) . rand(0, 20) . '.' . last($fileName);
        return $fileName;
    }

    private function cekDirectory($fileName)
    {
        $pathImage = storage_path("app/public/travel-galleries");
        if (!file_exists($pathImage)) mkdir($pathImage, 666, true);

        $pathThumbnail = storage_path("app/public/travel-galleries/thumbnails");
        if (!file_exists($pathThumbnail)) mkdir($pathThumbnail, 666, true);

        return [
            'pathImage' => $pathImage .= "/$fileName",
            'pathThumbnail' => $pathThumbnail .= "/$fileName"
        ];
    }

    private function deleteImage($fileName)
    {
        Storage::disk('public')
            ->delete("travel-galleries/$fileName");
        Storage::disk('public')
            ->delete("travel-galleries/thumbnails/$fileName");
    }
}
