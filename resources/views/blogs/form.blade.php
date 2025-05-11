
<div class="mb-3 row">
    <label for="title" class="col-form-label text-lg-end col-lg-2 col-xl-3">Title</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" type="text" id="title" value="{{ old('title', optional($blog)->title) }}" minlength="1" maxlength="255" placeholder="Enter title here...">
        {!! $errors->first('title', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="blog_category_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Category</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select form-control {{ $errors->has('blog_category_id') ? ' is-invalid' : '' }}" id="blog_category_id" name="blog_category_id">
        	    <option value="" style="display: none;" {{ old('blog_category_id', optional($blog)->blog_category_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select category</option>
        	@foreach ($blogCategories as $key => $blogCategory)
			    <option value="{{ $key }}" {{ old('blog_category_id', optional($blog)->blog_category_id) == $key ? 'selected' : '' }}>
			    	{{ $blogCategory }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('blog_category_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="image" class="col-form-label text-lg-end col-lg-2 col-xl-3">Image</label>
    <div class="col-lg-10 col-xl-9">
        <div class="mb-3">
            <input class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" type="file" name="image" id="image" class="">
        </div>

        @if (isset($blog->image) && !empty($blog->image))

        <div class="input-group mb-3">
          <div class="form-check">
            <input type="checkbox" name="custom_delete_image" id="custom_delete_image" class="form-check-input custom-delete-file" value="1" {{ old('custom_delete_image', '0') == '1' ? 'checked' : '' }}>
          </div>
          <label class="form-check-label" for="custom_delete_image"> Delete {{ $blog->image }}</label>
        </div>

        @endif

        {!! $errors->first('image', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="description" class="col-form-label text-lg-end col-lg-2 col-xl-3">Description</label>
    <div class="col-lg-10 col-xl-9">
        <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" id="description" minlength="1" maxlength="1000">{{ old('description', optional($blog)->description) }}</textarea>
        {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="source" class="col-form-label text-lg-end col-lg-2 col-xl-3">Source</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('source') ? ' is-invalid' : '' }}" name="source" type="text" id="source" value="{{ old('source', optional($blog)->source) }}" minlength="1" placeholder="Enter source here...">
        {!! $errors->first('source', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="blog_seo" class="col-form-label text-lg-end col-lg-2 col-xl-3">Blog Seo</label>
    <div class="col-lg-10 col-xl-9">
        <div class="form-check checkbox">
            <input id="blog_seo_1" class="form-check-input" name="blog_seo" type="checkbox" value="1" {{ old('blog_seo', optional($blog)->blog_seo) == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="blog_seo_1">
                Yes
            </label>
        </div>


        {!! $errors->first('blog_seo', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="meta_tag" class="col-form-label text-lg-end col-lg-2 col-xl-3">Meta Tag</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('meta_tag') ? ' is-invalid' : '' }}" name="meta_tag" type="text" id="meta_tag" value="{{ old('meta_tag', optional($blog)->meta_tag) }}" minlength="1" placeholder="Enter meta tag here...">
        {!! $errors->first('meta_tag', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="meta_description" class="col-form-label text-lg-end col-lg-2 col-xl-3">Meta Description</label>
    <div class="col-lg-10 col-xl-9">
        <textarea class="form-control{{ $errors->has('meta_description') ? ' is-invalid' : '' }}" name="meta_description" id="meta_description" minlength="1" placeholder="Enter meta description here...">{{ old('meta_description', optional($blog)->meta_description) }}</textarea>
        {!! $errors->first('meta_description', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

