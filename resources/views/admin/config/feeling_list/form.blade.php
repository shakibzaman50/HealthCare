
<div class="mb-3 row">
    <label for="name" class="col-form-label text-lg-end col-lg-2 col-xl-3">Name</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" type="text" id="name" value="{{ old('name', optional($feelingList)->name) }}" minlength="1" maxlength="30" placeholder="Enter name here...">
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="is_active" class="col-form-label text-lg-end col-lg-2 col-xl-3">Is Active</label>
    <div class="col-lg-10 col-xl-9">
        <div class="form-check checkbox mt-3">
            <input id="is_active_1" class="form-check-input" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($feelingList)->is_active) == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active_1">
                Yes
            </label>
        </div>


        {!! $errors->first('is_active', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="emoji" class="col-form-label text-lg-end col-lg-2 col-xl-3">Emoji</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('emoji') ? ' is-invalid' : '' }}" name="emoji" type="file" id="emoji" size="2024">
        {!! $errors->first('emoji', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

