<?php

namespace App\Http\Controllers;

use App\Repositories\TravelPackage\TravelPackageRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * The name of repository instance
     *
     * @var App\Services\TravelPackageService
     */
    private $travelPackageRepository;

    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(TravelPackageRepositoryInterface $travelPackageRepositoryInterface)
    {
        $this->travelPackageRepository = $travelPackageRepositoryInterface;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $travelPackages = $this->travelPackageRepository->getAllTravelPackagesByKeywordOrStatus()
            ->select(['id', 'title', 'slug', 'location'])
            ->onlyAvailable()
            ->withRelations(['firstTravelGallery'])
            ->hasRelations('travelGalleries')
            ->limit(4)
            ->get();

        $memberCount = countOfAllMembers();

        return view('pages.frontend.home', compact('travelPackages', 'memberCount'));
    }
}
