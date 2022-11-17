<?php

namespace App\Http\Controllers;

use App\Http\Requests\TravelPackageRequest;
use Illuminate\Http\Request;
use App\Models\TravelPackage;
use Illuminate\Support\Facades\Storage;

class TravelPackageController extends Controller
{

    public function __construct()
    {
        $this->middleware('authRoles:ADMIN,SUPERADMIN,2')->only('trash', 'restore', 'forceDelete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $status = $request->status;
        $travelPackages = $this->getTravelPackagesWithParams($keyword, $status);

        return  view('pages.backend.travel-packages.index', compact('travelPackages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.backend.travel-packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TravelPackageRequest $request)
    {
        $data = array_merge($request->validated(), [
            // 'slug' => Str::of($request->title)->lower()->slug(),
            'created_by' => auth()->id(),
            'price' => $this->convertPriceToInteger($request->validated()['price'])
        ]);

        TravelPackage::create($data);

        return redirect()->route('travel-packages.index')
            ->with('status', trans('status.create_new_travel_package'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TravelPackage  $travelPackage
     * @return \Illuminate\Http\Response
     */
    public function show(TravelPackage $travelPackage)
    {
        return view('pages.backend.travel-packages.detail', compact('travelPackage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TravelPackage  $travelPackage
     * @return \Illuminate\Http\Response
     */
    public function edit(TravelPackage $travelPackage)
    {
        return view('pages.backend.travel-packages.edit', compact('travelPackage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TravelPackage  $travelPackage
     * @return \Illuminate\Http\Response
     */
    public function update(TravelPackageRequest $request, TravelPackage $travelPackage)
    {
        $data = array_merge($request->validated(), [
            'updated_by' => auth()->id(),
            'price' => $this->convertPriceToInteger($request->validated()['price'])
        ]);

        $travelPackage->update($data);

        return redirect()->route('travel-packages.index')
            ->with('status', trans('status.update_travel_package', ['travelPackage' => $travelPackage->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TravelPackage  $travelPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(TravelPackage $travelPackage)
    {
        $travelPackage->update(['deleted_by' => auth()->id()]);

        $title = $travelPackage->title;
        $travelPackage->delete();

        return redirect()->route('travel-packages.index')
            ->with('status', trans('status.delete_travel_package', ['travelPackage' => $title]));
    }

    public function trash(Request $request)
    {
        $keyword = $request->keyword;
        $deletedTravelPackages = $this->getTravelPackagesWithParams($keyword, null, true);

        return view('pages.backend.travel-packages.trash', compact('deletedTravelPackages'));
    }

    public function restore(Request $request)
    {
        $travelPackageRestore = $this->getTravelPackageTrashedWithSlug($request->slug);

        $travelPackageRestore->update(['deleted_by' => null]);
        $travelPackageRestore->restore();

        return redirect()->route('travel-packages.trash')
            ->with('status', trans('status.restore_travel_package', ['travelPackage' => $travelPackageRestore->title]));
    }

    public function forceDelete(Request $request)
    {
        $travelPackageDelete = $this->getTravelPackageTrashedWithSlug($request->slug);

        $title = $travelPackageDelete->title;
        $this->deleteImage($travelPackageDelete);
        $travelPackageDelete->forceDelete();

        return redirect()->route('travel-packages.trash')
            ->with('status', trans('status.delete_permanent_travel_package', ['travelPackage' => $title]));
    }

    private function getTravelPackagesWithParams($keyword, $status = null, $trashed = false)
    {
        if ($trashed) {
            return TravelPackage::onlyTrashed()
                ->where(function ($query) use ($keyword) {
                    $query->where('title', 'LIKE', "%$keyword%")
                        ->orWhere('location', 'LIKE', "%$keyword%");
                })
                ->latest()
                ->paginate(10);
        }

        if ($status == '>' || $status == '<') {
            return TravelPackage::where('date_departure', $status, now())
                ->where(function ($query) use ($keyword) {
                    $query->where('title', 'LIKE', "%$keyword%")
                        ->orWhere('location', 'LIKE', "%$keyword%");
                })
                ->latest()
                ->paginate(10);
        }

        return TravelPackage::where('title', 'LIKE', "%$keyword%")
            ->orWhere('location', 'LIKE', "%$keyword%")
            ->latest()
            ->paginate(10);
    }

    private function getTravelPackageTrashedWithSlug($slug)
    {
        return TravelPackage::onlyTrashed()
            ->where('slug', $slug)
            ->firstOrFail();
    }

    private function convertPriceToInteger($value)
    {
        return preg_replace("/[^[0-9]/", "", $value);
    }

    private function deleteImage($travelPackage)
    {
        $galleries = $travelPackage->travelGalleries;
        if ($galleries->count()) {
            foreach ($galleries as $gallery) {
                Storage::disk('public')
                    ->delete("travel-galleries/{$gallery->name}");
                Storage::disk('public')
                    ->delete("travel-galleries/thumbnails/{$gallery->name}");
            }
        }
    }
}
