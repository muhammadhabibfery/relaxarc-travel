@extends('layouts.backend.master-backend')

@section('title', 'Detail User Profile')

@section('content')
<div class="container-fluid">

    <!--Page Heading & Content Detail -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Detail User', ['name' => $user->name]) }}</h1>
        @if (in_array('SUPERADMIN', auth()->user()->roles))
        <a href="{{ route('users.index') }}" class="btn btn-secondary d-none d-md-block mr-2">{{ __('Back') }}</a>
        @else
        <a href="{{ route('transactions.show', $invoiceNumber) }}" class="btn btn-secondary d-none d-md-block mr-2">{{
            __('Back') }}</a>
        @endif
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title" id="DetailtravelpackageModalLabel">
                        {{ $user->name }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row no-gutters">
                        <div class="col">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="card-title">{{ __('Name') }}</h5>
                                        <p class="card-text">{{ $user->name }}</p>
                                        <h5 class="card-title">{{ __('Username') }}
                                        </h5>
                                        <p class="card-text">{{ $user->username }}
                                        </p>
                                        <h5 class="card-title">{{ __('Phone') }}
                                        </h5>
                                        <p class="card-text">
                                            {{ $user->phone ?? '-' }}</p>
                                        <h5 class="card-title">{{ __('Email') }}
                                        </h5>
                                        <p class="card-text">{{ $user->email }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="card-title">{{ __('Verified') }}
                                        </h5>
                                        <p
                                            class="card-text{{ $user->email_verified_at ? ' text-primary' : ' text-danger' }}">
                                            {{ $user->email_verified_at ? 'OK' :
                                            'NONE' }}
                                        </p>
                                        <h5 class="card-title">{{ 'Status' }}
                                        </h5>
                                        <p
                                            class="card-text{{ $user->status === 'ACTIVE' ? ' text-primary' : ' text-danger' }}">
                                            {{ __($user->status) }}</p>
                                        <h5 class="card-title">{{ __('Roles') }}
                                        </h5>
                                        <ul class="card-text">
                                            @foreach ($user->roles as $role)
                                            <li>{{ $role }}</li>
                                            @endforeach
                                        </ul>
                                        <h5 class="card-title">{{ 'Address' }}
                                        </h5>
                                        <p>
                                            <small>{{ $user->address ?? '-' }}</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <div class="row justify-content-between">
                        <div class="col-md-4">
                            <small class="text-muted">
                                @if ($user->created_by)
                                {{ __('Created by :Name', ['Name' =>
                                createdUpdatedDeletedBy($user->created_by)->name]) }}
                                @endif
                            </small>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">
                                @if($user->updated_by)
                                {{ __('Last updated by :Name (:Date)',
                                ['Name' => createdUpdatedDeletedBy($user->updated_by)->name,
                                'date'=> $user->updated_at->diffForHumans()]) }}
                                @else
                                {{ __('Last updated :Date', ['date' => $user->updated_at->diffForHumans()]) }}
                                @endif
                            </small>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">
                                @if ($user->deleted_by)
                                {{ __('Deleted by :Name (:Date)',
                                ['Name' => createdUpdatedDeletedBy($user->deleted_by)->name,
                                'date' => $user->deleted_at->diffForHumans()]) }}
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
