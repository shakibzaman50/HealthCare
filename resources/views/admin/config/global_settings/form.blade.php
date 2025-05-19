
<div class="mb-3 row">
    <label for="logo" class="col-form-label text-lg-end col-lg-2 col-xl-3">Logo</label>
    <div class="col-lg-10 col-xl-9">
        <div class="mb-3">
            <input class="form-control{{ $errors->has('logo') ? ' is-invalid' : '' }}" type="file" name="logo" id="logo" class="">
        </div>

        @if (isset($globalSetting->logo) && !empty($globalSetting->logo))

        <div class="input-group mb-3">
          <div class="form-check">
            <input type="checkbox" name="custom_delete_logo" id="custom_delete_logo" class="form-check-input custom-delete-file" value="1" {{ old('custom_delete_logo', '0') == '1' ? 'checked' : '' }}> 
          </div>
          <label class="form-check-label" for="custom_delete_logo"> Delete {{ $globalSetting->logo }}</label>
        </div>

        @endif

        {!! $errors->first('logo', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="favicon" class="col-form-label text-lg-end col-lg-2 col-xl-3">Favicon</label>
    <div class="col-lg-10 col-xl-9">
        <div class="mb-3">
            <input class="form-control{{ $errors->has('favicon') ? ' is-invalid' : '' }}" type="file" name="favicon" id="favicon" class="">
        </div>

        @if (isset($globalSetting->favicon) && !empty($globalSetting->favicon))

        <div class="input-group mb-3">
          <div class="form-check">
            <input type="checkbox" name="custom_delete_favicon" id="custom_delete_favicon" class="form-check-input custom-delete-file" value="1" {{ old('custom_delete_favicon', '0') == '1' ? 'checked' : '' }}> 
          </div>
          <label class="form-check-label" for="custom_delete_favicon"> Delete {{ $globalSetting->favicon }}</label>
        </div>

        @endif

        {!! $errors->first('favicon', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="site_title" class="col-form-label text-lg-end col-lg-2 col-xl-3">Site Title</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('site_title') ? ' is-invalid' : '' }}" name="site_title" type="text" id="site_title" value="{{ old('site_title', optional($globalSetting)->site_title) }}" minlength="1" placeholder="Enter site title here...">
        {!! $errors->first('site_title', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="slogan" class="col-form-label text-lg-end col-lg-2 col-xl-3">Slogan</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('slogan') ? ' is-invalid' : '' }}" name="slogan" type="text" id="slogan" value="{{ old('slogan', optional($globalSetting)->slogan) }}" minlength="1" placeholder="Enter slogan here...">
        {!! $errors->first('slogan', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="phone" class="col-form-label text-lg-end col-lg-2 col-xl-3">Phone</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" type="text" id="phone" value="{{ old('phone', optional($globalSetting)->phone) }}" minlength="1" placeholder="Enter phone here...">
        {!! $errors->first('phone', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="email" class="col-form-label text-lg-end col-lg-2 col-xl-3">Email</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" type="email" id="email" value="{{ old('email', optional($globalSetting)->email) }}" placeholder="Enter email here...">
        {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="website" class="col-form-label text-lg-end col-lg-2 col-xl-3">Website</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('website') ? ' is-invalid' : '' }}" name="website" type="text" id="website" value="{{ old('website', optional($globalSetting)->website) }}" minlength="1" placeholder="Enter website here...">
        {!! $errors->first('website', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="address" class="col-form-label text-lg-end col-lg-2 col-xl-3">Address</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" type="text" id="address" value="{{ old('address', optional($globalSetting)->address) }}" minlength="1" placeholder="Enter address here...">
        {!! $errors->first('address', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

