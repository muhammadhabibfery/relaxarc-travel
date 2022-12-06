@extends('layouts.backend.master-backend')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Edit user') }}</h1>
        <a href="{{ route('users.index') }}" class="btn btn-secondary d-none d-md-block mr-2">{{ __('Back') }}</a>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mt-0">
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="POST" id="myfr"
                        onsubmit="return submitted(this)">
                        @csrf
                        @method('patch')
                        <div class=" form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ $user->name }}" readonly disabled>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">{{ __('Username') }}</label>
                            <input type="text" name="username"
                                class="form-control @error('username') is-invalid @enderror" id="username"
                                value="{{ $user->username }}" readonly disabled>
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="email" name="email" value="{{ $user->email }}"
                                class="form-control @error('email') is-invalid @enderror" id="email" readonly disabled>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">{{ __('Phone') }}</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                id="phone" value="{{ $user->phone }}" readonly disabled>
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">{{ __('Address') }}</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                                id="address" rows="3" readonly disabled>{{ $user->address }}</textarea>
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @if (checkRoles(["ADMIN",1], $user->roles))
                        <div class="form-group">
                            <label for="rolesLabel" class="d-block">{{ __('Roles') }}</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('roles') is-invalid @enderror" type="checkbox"
                                    name="roles[]" id="admin" value="admin" {{ in_array('ADMIN', $user->roles) ?
                                'checked' : '' }}>
                                <label class="form-check-label" for="admin">
                                    Admin
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('roles') is-invalid @enderror" type="checkbox"
                                    name="roles[]" id="superadmin" value="superadmin" {{ in_array('SUPERADMIN',
                                    $user->roles) ? 'checked' : '' }}>
                                <label class="form-check-label" for="superadmin">
                                    SuperAdmin
                                </label>
                            </div>
                            @error('roles')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="statusLabel" class="d-block">Status</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('status') is-invalid @enderror" type="radio"
                                    name="status" id="active" value="ACTIVE" {{ $user->status === 'ACTIVE' ? 'checked' :
                                '' }}>
                                <label class="form-check-label" for="active">ACTIVE</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('status') is-invalid @enderror" type="radio"
                                    name="status" id="none" value="NONE" {{ $user->status === 'NONE' ? 'checked' : ''
                                }}>
                                <label class="form-check-label" for="none">{{ __('NONE') }}</label>
                            </div>
                            @error('status')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-block btn-primary" id="btnfr">{{ __('Submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
