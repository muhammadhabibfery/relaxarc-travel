<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    @if ($type === 'detail')
    <h1 class="h3 mb-0 text-gray-800">{{ __('Detail Travel Package', ['Name' => $travelPackage->title]) }}</h1>
    @else
    <h1 class="h3 mb-0 text-gray-800">{{ __('Detail Deleted Travel Package', ['Name' => $travelPackage->title])
        }}
    </h1>
    @endif

    <a href="{{ str_contains(url()->previous(), 'transactions') ? route('transactions.show', $invoiceNumber) : route('travel-packages.index') }}"
        class="btn btn-secondary d-none d-md-block mr-2">{{ __('Back')
        }}</a>
</div>

<!-- Content Row -->
<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title" id="DetailtravelpackageModalLabel">
                    {{ $travelPackage->title }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="{{ $travelPackage->first_thumbnail }}" class="card-img" alt="Travel Package Cover">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h5 class="card-title">{{ __('Name') }}</h5>
                                    <p class="card-text">
                                        {{ $travelPackage->title }}
                                    </p>
                                    <h5 class="card-title">{{ __('Location') }}
                                    </h5>
                                    <p class="card-text">
                                        {{ $travelPackage->location }}
                                    </p>
                                    <h5 class="card-title">
                                        {{ __('Date of departure') }}
                                    </h5>
                                    <p class="card-text">
                                        {{ $travelPackage->date_departure_with_day }}
                                    </p>
                                    <h5 class="card-title">{{ __('Duration') }}
                                    </h5>
                                    <p class="card-text">
                                        {{ formatTravelPackageDuration($travelPackage->duration, app()->getLocale()) }}
                                    </p>
                                    <h5 class="card-title">{{ __('Type') }}</h5>
                                    <p class="card-text">
                                        {{ $travelPackage->type }}
                                    </p>
                                    <h5 class="card-title">{{ __('Price') }}
                                    </h5>
                                    <p class="card-text">
                                        @convertCurrency($travelPackage->price) {{ __(' / Person') }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="card-title">
                                        {{ __('Feautured event') }}
                                    </h5>
                                    <x-travel-packages.list-data
                                        :data="transformStringToArray($travelPackage->featured_event, ',')" />
                                    <h5 class="card-title">{{ __('Language') }}
                                    </h5>
                                    <x-travel-packages.list-data
                                        :data="transformStringToArray($travelPackage->language, ',')" />
                                    <h5 class="card-title">{{ __('Foods') }}
                                    </h5>
                                    <x-travel-packages.list-data
                                        :data="transformStringToArray($travelPackage->foods, ',')" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row no-gutterrs">
                    <div class="col">
                        <div class="card-body" style="margin-top: -30px;">
                            <h5 class="card-title">{{ __('About') }}
                            </h5>
                            <p class="card-text">
                                {{ $travelPackage->about }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <small class="text-muted">
                    {{ __('Created by :Name', ['Name' =>
                    createdUpdatedDeletedBy($travelPackage->created_by)->name ?? '-']) }}
                </small>
                <small class="text-muted float-md-right d-block d-md-inline-block d-lg-inline-block">
                    @if ($travelPackage->deleted_by)
                    {{ __('Deleted by :Name (:Date)',
                    ['Name' => createdUpdatedDeletedBy($travelPackage->deleted_by)->name,
                    'date' => $travelPackage->deleted_at->diffForHumans()]) }}
                    @elseif($travelPackage->updated_by)
                    {{ __('Last updated by :Name (:Date)',
                    ['Name' => createdUpdatedDeletedBy($travelPackage->updated_by)->name,
                    'date'=> $travelPackage->updated_at->diffForHumans()]) }}
                    @endif
                </small>
            </div>
        </div>
    </div>
</div>
