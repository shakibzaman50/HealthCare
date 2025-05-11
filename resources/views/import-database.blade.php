<!DOCTYPE html>
<html>
<head>
    <title>Import Database</title>
</head>
<body>
<h1>Import Database</h1>

@if(session('success'))
    <div style="color: green;">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('import.database') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="sql_file">Upload SQL File:</label>
    <input type="file" name="sql_file" required>
    <button type="submit">Import</button>
</form>
</body>
</html>
