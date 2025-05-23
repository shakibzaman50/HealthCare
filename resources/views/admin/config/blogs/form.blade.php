<style>
    .ck-editor__editable {
        min-height: 500px !important;
        height: 500px !important;
        padding: 20px !important;
        border: 1px solid #ddd !important;
        border-radius: 4px !important;
    }

    .ck.ck-editor {
        width: 100%;
    }

    .ck.ck-toolbar {
        border-radius: 4px 4px 0 0 !important;
        border: 1px solid #ddd !important;
        border-bottom: none !important;
    }

    .ck.ck-content {
        border-radius: 0 0 4px 4px !important;
    }

    .ck.ck-button {
        color: #333 !important;
    }

    .ck.ck-button:hover {
        background: #f0f0f0 !important;
    }

    .ck.ck-button.ck-on {
        background: #e6f3ff !important;
        color: #0066cc !important;
    }
</style>

<div class="mb-3 row">
    <label for="title" class="col-form-label text-lg-end col-lg-2 col-xl-3">Title</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" type="text" id="title"
            value="{{ old('title', optional($blog)->title) }}" minlength="1" maxlength="255"
            placeholder="Enter title here...">
        {!! $errors->first('title', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<div class="mb-3 row">
    <label for="tags" class="col-form-label text-lg-end col-lg-2 col-xl-3">Tags</label>
    <div class="col-lg-10 col-xl-9">
        <select
            class="js-example-basic-multiple form-select form-control {{ $errors->has('tags') ? ' is-invalid' : '' }}"
            id="tags" name="tags[]" multiple="multiple">
            <option disabled>Select Teg</option>
            @foreach ($allTags as $tag)
            <option value="{{ $tag }}" {{ old('tags') ? (in_array($tag, old('tags')) ? 'selected' : '' ) :
                (in_array($tag, explode(', ', optional($blog)->tags)) ? ' selected' : '' ) }}>{{ $tag }}</option>
            @endforeach
        </select>
        {!! $errors->first('tags', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

{{-- <option value="{{ $tag }}" {{ old('tags', optional($blog)->tags) == $tag ? 'selected' : '' }}>--}}
    {{-- {{ $tag }}--}}
    {{-- </option>--}}

<div class="mb-3 row">
    <label for="image" class="col-form-label text-lg-end col-lg-2 col-xl-3">Thumbnail</label>
    <div class="col-lg-10 col-xl-9">
        <div class="mb-3">
            <input class="form-control{{ $errors->has('thumbnail') ? ' is-invalid' : '' }}" type="file" name="thumbnail"
                id="thumbnail">
        </div>
        {!! $errors->first('image', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="is_active" class="col-form-label text-lg-end col-lg-2 col-xl-3">Is Active</label>
    <div class="col-lg-10 col-xl-9">
        <div class="form-check checkbox mt-3">
            <input id="is_active_1" class="form-check-input" name="is_active" type="checkbox" value="1" {{
                old('is_active', optional($blog)->is_active) == '1' ? 'checked' : '' }}>
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
        <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content"
            id="editor">{!! old('content', optional($blog)->content) !!}</textarea>
        {!! $errors->first('content', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>


<script>
    class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }

        upload() {
            return this.loader.file
                .then(file => new Promise((resolve, reject) => {
                    const formData = new FormData();
                    formData.append('upload', file);

                    fetch('/admin/upload-image', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.error) {
                            reject(result.error);
                        } else {
                            resolve({
                                default: result.url
                            });
                        }
                    })
                    .catch(error => {
                        reject(error);
                    });
                }));
        }

        abort() {
            // Abort upload process
        }
    }

    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new MyUploadAdapter(loader);
        };
    }

    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });

    ClassicEditor
        .create(document.querySelector('#editor'), {
            extraPlugins: [MyCustomUploadAdapterPlugin],
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'fontSize',
                    'fontFamily',
                    'fontColor',
                    'fontBackgroundColor',
                    '|',
                    'bold',
                    'italic',
                    'underline',
                    'strikethrough',
                    '|',
                    'alignment',
                    '|',
                    'numberedList',
                    'bulletedList',
                    '|',
                    'outdent',
                    'indent',
                    '|',
                    'link',
                    'blockQuote',
                    'insertTable',
                    'mediaEmbed',
                    '|',
                    'imageUpload',
                    '|',
                    'undo',
                    'redo'
                ]
            },
            image: {
                toolbar: [
                    'imageTextAlternative',
                    'imageStyle:inline',
                    'imageStyle:block',
                    'imageStyle:side',
                    'toggleImageCaption',
                    'linkImage'
                ],
                upload: {
                    types: ['jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff']
                }
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells',
                    'tableProperties',
                    'tableCellProperties'
                ]
            },
            fontSize: {
                options: [
                    'tiny',
                    'small',
                    'default',
                    'big',
                    'huge'
                ]
            },
            fontFamily: {
                options: [
                    'default',
                    'Arial, Helvetica, sans-serif',
                    'Courier New, Courier, monospace',
                    'Georgia, serif',
                    'Lucida Sans Unicode, Lucida Grande, sans-serif',
                    'Tahoma, Geneva, sans-serif',
                    'Times New Roman, Times, serif',
                    'Trebuchet MS, Helvetica, sans-serif',
                    'Verdana, Geneva, sans-serif'
                ]
            },
            language: 'en',
            placeholder: 'Write your blog content here...'
        })
        .then(editor => {
            const editableElement = editor.ui.view.editable.element;
            editableElement.style.minHeight = '500px';
            editableElement.style.height = '500px';
            editableElement.style.padding = '20px';
            editableElement.style.border = '1px solid #ddd';
            editableElement.style.borderRadius = '4px';
        })
        .catch(error => {
            console.error(error);
        });
</script>