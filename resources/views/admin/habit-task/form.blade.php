<div class="mb-3 row">
    <label for="habitListId" class="col-form-label text-lg-end col-lg-2 col-xl-3">Habit List</label>
    <div class="col-lg-10 col-xl-9">
        <select name="habit_list_id" id="habitListId" class="form-control{{ $errors->has('habit_list_id') ? ' is-invalid' : '' }}">
            <option selected disabled>Select Habit List</option>
            @foreach($habitLists as $list)
                <option value="{{ $list->id }}" {{ old('habit_list_id') ? (old('habit_list_id')==$list->id ? 'selected' : '') : (optional($habitTask)->habit_list_id==$list->id ? 'selected' : '') }}>{{ $list->name }}</option>
            @endforeach
        </select>
{{--        <input value="{{ old('name', optional($habitTask)->name) }}">--}}
        {!! $errors->first('habit_list_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="name" class="col-form-label text-lg-end col-lg-2 col-xl-3">Name</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" type="text" id="name" value="{{ old('name', optional($habitTask)->name) }}" minlength="1" maxlength="30" placeholder="Enter name here...">
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="is_active" class="col-form-label text-lg-end col-lg-2 col-xl-3">Is Active</label>
    <div class="col-lg-10 col-xl-9">
        <div class="form-check checkbox mt-3">
            <input id="is_active_1" class="form-check-input" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($habitTask)->is_active) == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active_1">
                Yes
            </label>
        </div>


        {!! $errors->first('is_active', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="icon" class="col-form-label text-lg-end col-lg-2 col-xl-3">Icon</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('icon') ? ' is-invalid' : '' }}" name="icon" type="file" id="icon" size="2024" >
        {!! $errors->first('icon', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

