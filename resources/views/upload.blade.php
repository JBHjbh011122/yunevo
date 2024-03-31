<!DOCTYPE html>
<html>
<head>
    <title>Upload Image to S3</title>
</head>
<body>
    <form action="{{ url('/upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="image">Image:</label>
        <input type="file" name="image" id="image">
        <button type="submit">Upload</button>
    </form>
</body>
</html>
