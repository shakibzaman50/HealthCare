<style>
    .ck-editor__editable {
        min-height: 300px !important;
        height: 300px !important;
    }
</style>

<div class="mb-3 row">
    <label for="title" class="col-form-label text-lg-end col-lg-2 col-xl-3">Title</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" type="text" id="title" value="{{ old('title', optional($blog)->title) }}" minlength="1" maxlength="255" placeholder="Enter title here...">
        {!! $errors->first('title', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
\
<div class="mb-3 row">
    <label for="tags" class="col-form-label text-lg-end col-lg-2 col-xl-3">Tags</label>
    <div class="col-lg-10 col-xl-9">
        <select class="js-example-basic-multiple form-select form-control {{ $errors->has('tags') ? ' is-invalid' : '' }}" id="tags" name="tags[]" multiple="multiple">
            <option disabled >Select Teg</option>
            @foreach ($allTags as $tag)
                <option value="{{ $tag }}" {{ old('tags') ? (in_array($tag, old('tags')) ? 'selected' : '') : (in_array($tag, explode(', ', optional($blog)->tags)) ? 'selected' : '') }}>{{ $tag }}</option>
            @endforeach
        </select>
        {!! $errors->first('tags', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

{{--                  <option value="{{ $tag }}" {{ old('tags', optional($blog)->tags) == $tag ? 'selected' : '' }}>--}}
{{--                      {{ $tag }}--}}
{{--                  </option>--}}

<div class="mb-3 row">
    <label for="image" class="col-form-label text-lg-end col-lg-2 col-xl-3">Thumbnail</label>
    <div class="col-lg-10 col-xl-9">
        <div class="mb-3">
            <input class="form-control{{ $errors->has('thumbnail') ? ' is-invalid' : '' }}" type="file" name="thumbnail" id="thumbnail">
        </div>
        {!! $errors->first('image', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="is_active" class="col-form-label text-lg-end col-lg-2 col-xl-3">Is Active</label>
    <div class="col-lg-10 col-xl-9">
        <div class="form-check checkbox mt-3">
            <input id="is_active_1" class="form-check-input" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($blog)->is_active) == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active_1">
                Yes
            </label>
        </div>
        {!! $errors->first('blog_seo', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>


<div class="mb-3 row">
    <label for="editor" class="col-form-label text-lg-end col-lg-2 col-xl-3">Content</label>
    <div class="col-lg-10 col-xl-9">
        <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
        <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content" id="editor">{!! old('content', optional($blog)->content) !!}</textarea>
        {!! $errors->first('content', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
    // ClassicEditor
    ClassicEditor
        .create(document.querySelector('#editor'), {
            simpleUpload: {
                uploadUrl: '/upload-editor-image',
                headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        })
        .then(editor => {
          const editableElement = editor.ui.view.editable.element;
          editableElement.style.minHeight = '300px';
          editableElement.style.height = '300px';
        })
        .catch(error => {
            console.error(error);
        });
</script>

