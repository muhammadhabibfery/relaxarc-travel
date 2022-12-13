<!-- Desktop Searchbar -->
<div class="col-md-11 d-none d-md-block">
    <div class="row">
        <div class="col-md-10{{ $file === 'trash' ? ' col-lg-10 mb-4' : '' }}">
            <form action="{{ $route }}" method="GET" class="form-inline">
                <label for="keyword" class="sr-only"></label>
                <input type="text" name="keyword" class="form-control w-50 mr-3" id="keyword"
                    placeholder="{{ __('Search travel packages') }}" value="{{ request()->keyword }}">
                <div class="form-group">
                    <select name="status" class="form-control status-select2" style="width: 9em">
                        <option></option>
                        <option value='IN CART' {{ request()->status == 'IN CART' ? 'selected' : '' }}>IN CART</option>
                        <option value='PENDING' {{ request()->status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                        <option value='SUCCESS' {{ request()->status == 'SUCCESS' ? 'selected' : '' }}>SUCCESS</option>
                        <option value='FAILED' {{ request()->status == 'FAILED' ? 'selected' : '' }}>FAILED</option>
                    </select>
                </div>
                <button class="btn btn-primary mx-2 ml-3" type="submit" id="button-addon2">{{ __('Search') }}</button>
                <a href="{{ $route }}" class="btn btn-dark d-inline-block" id="button-addon2">Reset</a>
            </form>
        </div>
        @if ($file === 'trash')
        <div class="col-lg-2 d-none d-lg-block">
            <div class="float-md-right">
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Mobile Searchbar -->
<div class="col-sm-12 d-sm-block d-md-none">
    <form action="{{ $route }}" method="GET">
        <div class="form-group">
            <label for="keyword" class="sr-only"></label>
            <input type="text" name="keyword" class="form-control w-100" id="keyword"
                placeholder="{{ __('Search travel packages') }}" value="{{ request()->keyword }}">
        </div>
        <div class="form-group">
            <select name="status" class="form-control status-select2">
                <option></option>
                <option value='IN CART' {{ request()->status == 'IN CART' ? 'selected' : '' }}>IN CART</option>
                <option value='PENDING' {{ request()->status == 'PENDING' ? 'selected' : '' }}>PENDING></option>
                <option value='SUCCESS' {{ request()->status == 'SUCCESS' ? 'selected' : '' }}>SUCCESS</option>
                <option value='CANCEL' {{ request()->status == 'CANCEL' ? 'selected' : '' }}>CANCEL</option>
                <option value='FAILED' {{ request()->status == 'FAILED' ? 'selected' : '' }}>FAILED</option>
            </select>
        </div>
        <div class="form-group mt-3">
            <div class="row justify-content-center">
                <div class="col-6">
                    <button class="btn btn-primary btn-block mx-2" type="submit" id="button-addon2">{{
                        __('Search') }}</button>
                </div>
                <div class="col-6">
                    <a href="{{ $route }}" class="btn btn-dark btn-block d-inline-block" id="button-addon2">Reset</a>
                </div>
            </div>
        </div>
    </form>
    @if ($file === 'trash')
    <a href="{{ route('transactions.index') }}" class="btn btn-block btn-secondary my-3">{{ __('Back') }}</a>
    @endif
</div>
