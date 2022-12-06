@extends('layouts.backend.master-backend')

@section('title', 'Manage Users')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Manage users') }}</h1>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">

        <!-- Mobile Searchbar -->
        <div class="col-sm-12 d-sm-block d-md-none">
            <form action="{{ route('users.index') }}" method="GET">
                <input type="hidden" name="role" value="{{ request()->role ?? null }}">
                <div class="form-group">
                    <label for="keyword" class="sr-only"></label>
                    <input type="text" name="keyword" class="form-control w-100" id="keyword"
                        placeholder="{{ __('Search by name or username') }}" value="{{ request()->keyword }}">
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="status" class="form-check-input" id="active" value="active" {{
                        request()->status == 'active' ? 'checked' : '' }}>
                    <label for="active" class="form-check-label">ACTIVE</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="status" class="form-check-input" id="inactive" value="none" {{
                        request()->status == 'none' ? 'checked' : '' }}>
                    <label for="inactive" class="form-check-label">INACTIVE</label>
                </div>
                <div class="form-group mt-3">
                    <button class="btn btn-primary mx-2" type="submit" id="button-addon2">{{ __('Search') }}</button>
                    <a href="{{ route('users.index') }}" class="btn btn-dark d-inline-block"
                        id="button-addon2">Reset</a>
                </div>
            </form>
        </div>

        <!-- Desktop Searchbar -->
        <div class="col-md-11 d-none d-md-block">
            <form action="{{ route('users.index') }}" method="GET" class="form-inline">
                <input type="hidden" name="role" value="{{ request()->role ?? null }}">
                <label for="keyword" class="sr-only"></label>
                <input type="text" name="keyword" class="form-control w-50" id="keyword"
                    placeholder="{{ __('Search by name or username') }}" value="{{ request()->keyword }}">
                <div class="form-check form-check-inline ml-4">
                    <input type="radio" name="status" class="form-check-input" id="active" value="active" {{
                        request()->status == 'active' ? 'checked' : '' }}>
                    <label for="active" class="form-check-label">ACTIVE</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="status" class="form-check-input" id="inactive" value="none" {{
                        request()->status == 'none' ? 'checked' : '' }}>
                    <label for="inactive" class="form-check-label">INACTIVE</label>
                </div>
                <button class="btn btn-primary mx-2" type="submit" id="button-addon2">{{ __('Search') }}</button>
                <a href="{{ route('users.index') }}" class="btn btn-dark d-inline-block" id="button-addon2">Reset</a>
            </form>
        </div>

        <div class="col-md-11 my-4">
            <a href="{{ route('users.create') }}" class="btn btn-dark-blue btn-block">{{ __('Add new admin') }}</a>
        </div>

        <div class="col-md-11">

            <div class="row justify-content-start mt-1">
                <div class="col-md-10">
                    <ul class="nav nav-pills card-header-pills pl-4">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->role === null && request()->routeIs('users.index') ? 'active' : '' }}"
                                href="{{ route('users.index', ['keyword' => request()->keyword, 'status' => request()->status]) }}">{{
                                __('All') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->role === 'admin' ? 'active' : '' }}"
                                href="{{ route('users.index', ['role' => 'admin', 'keyword' => request()->keyword, 'status' => request()->status]) }}">Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->role === 'member' ? 'active' : '' }}"
                                href="{{ route('users.index', ['role' => 'member', 'keyword' => request()->keyword, 'status' => request()->status]) }}">Member</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card mt-0">
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">{{ __('Level') }}</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                <tr>
                                    <th scope="row">{{ $users->currentPage() * 10 - 10 + $loop->iteration }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach ($user->roles as $role)
                                        {{ !$loop->last ? $role . ',' : $role }}
                                        @endforeach
                                    </td>
                                    <td>
                                        <span
                                            class="{{ $user->status === 'ACTIVE' ? 'text-dark-blue' : 'text-danger' }} text-monospace">
                                            {{ __($user->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('detail-profile', [$user->username]) }}"
                                            class="btn btn-success btn-sm my-1">Detail</a>
                                        @can('update', $user)
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="btn btn-warning btn-sm my-1">Edit</a>
                                        @endcan
                                        @can('delete', $user)
                                        <a href="#" class="btn btn-danger btn-sm my-1" data-toggle="modal"
                                            data-target="#deleteUser{{ $user->username }}Modal">Delete</a>
                                        @endcan
                                    </td>

                                    {{-- Delete User Modal --}}
                                    <div class="modal fade" id="deleteUser{{ $user->username }}Modal" tabindex="-1"
                                        role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        {{ __('Delete user') }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{{ __('Are you sure want to delete user permanently ?', ['data'
                                                        => 'pengguna', 'name' => $user->name]) }}
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                        onsubmit="return submitted(this)" id="myfr">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-primary" id="btnfr">{{
                                                            __('Delete') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">
                                        <p class="font-weight-bold text-center text-monospace">
                                            {{ __('Users not available') }}</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->withQueryString()->onEachSide(2)->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
