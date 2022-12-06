<div class="row justify-content-center">
    <div class="col-md-10">
        <section class="section-travel-list pl-lg-0 mb-3 mb-lg-0">
            <div class="table-responsive-sm">
                <div class="card card-travels card-terms-conditions p-3">

                    <form action="{{ route('update-profile') }}" method="POST" enctype="multipart/form-data" id="myfr"
                        onsubmit="return submitted(this)">
                        @method('patch')
                        @csrf

                        @if (!$user->isCompleteProfile)
                        <small class="mb-4 font-italic text-danger">
                            *{{ __('complete your profile information before continuing the journey') }}
                        </small>
                        @endif

                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name', $user->name) }}">
                            @error('name')
                            <span class="invalid-feedback error-background" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">{{ __('Username') }}</label>
                            <input type="text" name="username"
                                class="form-control @error('username') is-invalid @enderror" id="username"
                                value="{{ old('username', $user->username) }}">
                            @error('username')
                            <span class="invalid-feedback error-background" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="form-control @error('email') is-invalid @enderror" id="email"
                                aria-describedby="emailHelp">
                            @error('email')
                            <span class="invalid-feedback error-background" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">{{ __('Phone') }}</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                id="phone" value="{{ $user->phone ? old('phone', $user->phone) : old('phone') }}">
                            @error('phone')
                            <span class="invalid-feedback error-background" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">{{ __('Address') }}</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                                id="address"
                                rows="3">{{ $user->address ? old('address', $user->address) : old('address') }}</textarea>
                            @error('address')
                            <span class="invalid-feedback error-background" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <p>{{ __('Your current profile picture') }}</p>
                                    <img src="{{ $user->getAvatar() }}" alt="{{ __('Profile picture') }}"
                                        class="img-thumbnail img-fluid rounded-circle w-50 mb-2 profile-image">
                                    @if ($user->avatar)
                                    <a href="#" class="btn btn-secondary mb-4 mb-md-0 mb-lg-0 mb-xl-0 d-block"
                                        data-toggle="modal" data-target="#deleteAvatarModal">
                                        {{ __('Delete avatar') }}
                                    </a>
                                    @endif
                                </div>
                                <div class="col-sm-8 my-auto">
                                    <label for="image">{{ __('Choose profile picture') }}</label>
                                    <input type="file" name="image" id="image"
                                        class="form-control @error('image') is-invalid @enderror">
                                    @error('image')
                                    <span class="invalid-feedback error-background" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="btnfr" class="btn btn-primary btn-block mt-3" id="btnfr">{{
                                __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Delete Avatar Modal-->
<x-profiles.delete-avatar-modal />
