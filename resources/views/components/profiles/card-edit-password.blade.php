<div class="row justify-content-center">
    <div class="col-md-10">
        <section class="section-travel-list pl-lg-0 mb-3 mb-lg-0">
            <div class="table-responsive-sm">
                <div class="card card-travels card-terms-conditions p-3">

                    <form action="{{ route('update-password') }}" method="POST" id=" myfr"
                        onsubmit="return submitted(this)">
                        @method('patch')
                        @csrf
                        <div class="form-group">
                            <label for="current_password">{{ __('Current password') }}</label>
                            <input type="password" name="current_password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                id="current_password">
                            @error('current_password')
                            <span class="invalid-feedback error-background" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_password">{{ __('New password') }}</label>
                            <input type="password" name="new_password"
                                class="form-control @error('new_password') is-invalid @enderror" id="new_password">
                            @error('new_password')
                            <span class="invalid-feedback error-background" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirmation">{{ __('Password confirmation') }}</label>
                            <input type="password" name="new_password_confirmation"
                                class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                id="new_password_confirmation">
                            @error('new_password_confirmation')
                            <span class="invalid-feedback error-background" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="fprm-group">
                            <button type="submit" name="btnfr" class="btn btn-primary btn-block mt-3" id="btnfr">{{
                                __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
