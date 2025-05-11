
<div class="mb-3 row">
    <label for="ip_address" class="col-form-label text-lg-end col-lg-2 col-xl-3">Ip Address</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('ip_address') ? ' is-invalid' : '' }}" name="ip_address" type="text" id="ip_address" value="{{ old('ip_address', optional($bannedIp)->ip_address) }}" minlength="1" placeholder="Enter ip address here...">
        {!! $errors->first('ip_address', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>


