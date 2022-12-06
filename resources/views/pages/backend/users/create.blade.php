@extends('layouts.backend.master-backend')

@section('title', 'Create Admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Add new admin') }}</h1>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mt-0">
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST" id="myfr" onsubmit="return submitted(this)">
                        @csrf
                        <div class=" form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name') }}">
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
                                value="{{ old('username') }}">
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror" id="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">{{ __('Phone') }}</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                id="phone" value="{{ old('phone') }}">
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">{{ __('Address') }}</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                                id="address" rows="3">{{ old('address') }}</textarea>
                            @error('roles')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="roles">{{ __('Roles') }}</label>
                            <div class="form-check">
                                <input class="form-check-input @error('roles') is-invalid @enderror" type="radio"
                                    name="roles" id="roles" value="admin" checked>
                                <label class="form-check-label" for="roles">
                                    Admin
                                </label>
                                @error('roles')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-block btn-primary" id="btnfr">{{ __('Submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('addon_scripts')
<script>
    const inputNameElement = document.querySelector('#name');
    const inputUsernameElement = document.querySelector('#username');

    inputNameElement.addEventListener('change', function(){
        const inputNameValue = inputNameElement.value;

        fetch("{{ route('users.generate-username') }}", {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                "name": inputNameValue
            })
        })
        .then(response => response.json())
        .then(data => inputUsernameElement.value = data.username)
        .catch(error => {
            alert("500 internal server error, {{ __('Refresh the page') }}");
            location.reload();
        });
    });
</script>
@endpush
