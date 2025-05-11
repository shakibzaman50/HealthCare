<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name ?? '') }}"
        required>
</div>
<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" id="description" class="form-control" cols="30" rows="10"
        required>{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="category_id" class="form-label">Category</label>
    <select name="category_id" id="category_id" class="form-select" required>
        @foreach($categories as $category)
        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') ==
            $category->id ? 'selected' : '' }}>
            {{ $category->name }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="unit_id" class="form-label">Unit</label>
    <select name="unit_id" id="unit_id" class="form-select" required>
        @foreach($units as $unit)
        <option value="{{ $unit->id }}" {{ old('unit_id', $product->unit_id?? '')==$unit->id ?
            'selected' : '' }}>
            {{ $unit->name }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="price" class="form-label">Price</label>
    <input type="text" name="price" id="price" class="form-control" value="{{ old('price',$product->price ?? 0) }}"
        required>
</div>

<div class="mb-3">
    <label for="discount" class="form-label">Discount</label>
    <input type="text" name="discount" id="discount" class="form-control"
        value="{{ old('discount',$product->discount ?? 0) }}">
</div>

<div class="mb-3">
    <label for="wholesell_price" class="form-label">Wholesale Price</label>
    <input type="text" name="wholesell_price" id="wholesell_price" class="form-control"
        value="{{ old('wholesell_price',$product->wholesell_price ?? 0) }}">
</div>

<div class="mb-3">
    <label for="image" class="form-label">Image</label>
    <input type="file" name="image" id="image" class="form-control">
    @if(isset($product) && $product->image)
    <div class="mt-2">
        <img src="{{ asset('images/products/thumb/' . $product->image) }}" alt="{{ $product->name }}" width="100">
    </div>
    @endif
</div>

@if(old('status',$product->status ?? '') !== null)
<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select name="status" id="status" class="form-select">
        @foreach($statuses as $key=>$value)
        <option value="{{ $key }}" {{ old('status',$product->status ?? '')==$key ? 'selected' : '' }}>{{ $value }}
        </option>
        @endforeach
    </select>
</div>
@endif

<button type="submit" class="btn btn-primary">Create Product</button>