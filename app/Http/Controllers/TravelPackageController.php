<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TravelPackageService;
use App\Http\Requests\TravelPackageRequest;

class TravelPackageController extends Controller
{
    /**
     * The name of service instance
     *
     * @var App\Services\TravelPackageService
     */
    private $travelPackageService;

    /**
     * Create a new service instance and implement authenticatedRoles middleware.
     *
     * @return void
     */
    public function __construct(TravelPackageService $travelPackageService)
    {
        $this->middleware('authRoles:ADMIN,SUPERADMIN,2')->only('trash', 'restore', 'forceDelete');
        $this->travelPackageService = $travelPackageService;
    }

    /**
     * Display a listing of the resource in member or guest page.
     *
     * @return \Illuminate\Http\Response
     */
    public function frontIndex()
    {
        $travelPackages = $this->travelPackageService->takeAllAvailableTravelPackagesWithRelations(['firstTravelGallery']);

        return view('pages.frontend.travel-packages-index', compact('travelPackages'));
    }

    /**
     * Display the specified resource in member or guest page.
     *
     * @return \Illuminate\Http\Response
     */
    public function frontShow(?string $slug)
    {
        $travelPackage = $this->travelPackageService
            ->takeOneTravelPackageWithRelations($slug, ['travelGalleries' => fn ($query) => $query->select('travel_package_id', 'name')]);

        return view('pages.frontend.travel-packages-detail', compact('travelPackage'));
    }

    /**
     * Display a listing of the resource in the admin page.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $travelPackages = $this->travelPackageService->takeAllTravelPackages($request);

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
     * @param  \App\Http\Requests\TravelPackageRequest  $request
     * @return mixed
     */
    public function store(TravelPackageRequest $request)
    {
        return $this->checkTheProccess('travel-packages.index', 'status.create_new_travel_package', function () use ($request) {
            $this->travelPackageService->storeTravelPackage($request->validated());
        });
    }

    /**
     * Display the specified resource in admin page.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show(?string $slug, ?string $invoiceNumber = null)
    {
        $travelPackage = $this->travelPackageService->takeOneTravelPackage($slug);

        return view('pages.backend.travel-packages.detail', compact('travelPackage', 'invoiceNumber'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit(?string $slug)
    {
        $travelPackage = $this->travelPackageService->takeOneTravelPackage($slug);

        $this->authorize('update', $travelPackage);

        return view('pages.backend.travel-packages.edit', compact('travelPackage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TravelPackageRequest  $request
     * @param  string  $slug
     * @return mixed
     */
    public function update(TravelPackageRequest $request, ?string $slug)
    {
        [$travelPackage, $travelPackageAction] = $this->travelPackageService->takeOneTravelPackage($slug, 'update');

        $this->authorize('update', $travelPackage);

        return $this->checkTheProccess(
            'travel-packages.index',
            'status.update_travel_package',
            function () use ($travelPackageAction, $request) {
                $travelPackageAction->updateTravelPackage($request->validated());
            }
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return mixed
     */
    public function destroy(?string $slug)
    {
        $travelPackageAction = last($this->travelPackageService->takeOneTravelPackage($slug, 'delete'));

        return $this->checkTheProccess(
            'travel-packages.index',
            'status.delete_travel_package',
            function () use ($travelPackageAction) {
                $this->travelPackageService->useDBTransaction(function () use ($travelPackageAction) {
                    $travelPackageAction->updateTravelPackage(['deleted_by' => auth()->id()], false)
                        ->softDeleteTravelPackage();
                });
            }
        );
    }

    /**
     * Display a listing of the deleted resource in the admin page.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function indexTrash(Request $request)
    {
        $deletedTravelPackages = $this->travelPackageService->takeAllDeletedTravelPackages($request);

        return view('pages.backend.travel-packages.trash.index-trash', compact('deletedTravelPackages'));
    }

    /**
     * Display the specified deleted resource in admin page.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function showTrash(?string $slug)
    {
        $deletedTravelPackage = $this->travelPackageService->takeOneDeletedTravelPackage($slug);

        return view('pages.backend.travel-packages.trash.detail-trash', compact('deletedTravelPackage'));
    }

    /**
     * restore the specified deleted resource.
     *
     * @param  string  $slug
     * @return mixed
     */
    public function restore(?string $slug)
    {
        [$deletedTravelPackage, $deletedTravelPackageAction] = $this->travelPackageService->takeOneDeletedTravelPackage($slug, 'restore');

        $this->authorize('restore', $deletedTravelPackage);

        return $this->checkTheProccess(
            'travel-packages.trash',
            'status.restore_travel_package',
            function () use ($deletedTravelPackageAction) {
                $this->travelPackageService->useDBTransaction(function () use ($deletedTravelPackageAction) {
                    $deletedTravelPackageAction->updateTravelPackage(['deleted_by' => null], false)
                        ->restoreDeletedTravelPackage();
                });
            }
        );
    }

    /**
     * remove the specified deleted resource
     *
     * @param  string $slug
     * @return mixed
     */
    public function forceDelete(?string $slug)
    {
        $deletedTravelPackageAction = last($this->travelPackageService->takeOneDeletedTravelPackage($slug, 'forceDelete'));

        return $this->checkTheProccess(
            'travel-packages.trash',
            'status.delete_permanent_travel_package',
            function () use ($deletedTravelPackageAction) {
                $deletedTravelPackageAction->deleteTravelPackageImages()
                    ->removeDeletedTravelPackage();
            }
        );
    }

    /**
     * Check one or more processes and catch them if fail
     *
     * @param  string $redirectRoute
     * @param  string $successMessage
     * @param  callable $action
     * @return \Illuminate\Http\Response
     */
    private function checkTheProccess(string $redirectRoute, string $successMessage, callable $action)
    {
        try {
            $action();
        } catch (\Exception $e) {
            return redirect()->route($redirectRoute)
                ->with('failed', $e->getMessage());
        }

        return redirect()->route($redirectRoute)
            ->with('success', trans($successMessage));
    }
}
