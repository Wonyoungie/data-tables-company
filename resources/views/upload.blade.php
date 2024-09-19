<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload PDF</title>
</head>
<body>
    <h1>Upload Laporan PDF</h1>
    <form action="{{ route('upload-file') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="student_id">Student ID:</label>
        <input type="number" name="student_id" id="student_id" required>
        <br>
        <label for="file">Pilih file PDF:</label>
        <input type="file" name="file" accept="application/pdf" required>
        <button type="submit">Upload</button>
    </form>

    @if (session('filePath'))
        <p>File uploaded successfully! You can access it <a href="{{ url('file/' . basename(session('filePath'))) }}">here</a>.</p>
    @endif
</body>
</html>
