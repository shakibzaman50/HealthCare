<div class="mb-3 row">
    <label for="name" class="col-form-label text-lg-end col-lg-2 col-xl-3">Name</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" type="text" id="name"
            value="{{ old('name', optional($slider)->name) }}" minlength="1" maxlength="255"
            placeholder="Enter name here...">
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="text" class="col-form-label text-lg-end col-lg-2 col-xl-3">Text</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" name="text" type="text" id="text"
            value="{{ old('text', optional($slider)->text) }}" minlength="1" placeholder="Enter text here...">
        {!! $errors->first('text', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="image" class="col-form-label text-lg-end col-lg-2 col-xl-3">Image</label>
    <div class="col-lg-10 col-xl-9">
        <div class="mb-3">
            <input class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" type="file" name="image"
                id="image" class="">
        </div>

        @if (isset($slider->image) && !empty($slider->image))

        <div class="input-group mb-3">
            <div class="form-check">
                <input type="checkbox" name="custom_delete_image" id="custom_delete_image"
                    class="form-check-input custom-delete-file" value="1" {{ old('custom_delete_image', '0' )=='1'
                    ? 'checked' : '' }}>
            </div>
            <label class="form-check-label" for="custom_delete_image"> Delete {{ $slider->image }}</label>
        </div>

        @endif

        {!! $errors->first('image', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="link" class="col-form-label text-lg-end col-lg-2 col-xl-3">Link</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}" name="link" type="text" id="link"
            value="{{ old('link', optional($slider)->link) }}" minlength="1" placeholder="Enter link here...">
        {!! $errors->first('link', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="status" class="col-form-label text-lg-end col-lg-2 col-xl-3">Status</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('status') ? ' is-invalid' : '' }}" id="status" name="status">
            <option value="" style="display: none;" {{ old('status', optional($slider)->status ?: '') == '' ? 'selected'
                : '' }} disabled selected>Select Status...</option>
            @foreach (['active' => '1',
            'inactive' => '0'] as $key => $text)
            <option value="{{ $text }}" {{ old('status', optional($slider)->status) == $text ? 'selected' : '' }}>
                {{ $key }}
            </option>
            @endforeach
        </select>

        {!! $errors->first('status', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>