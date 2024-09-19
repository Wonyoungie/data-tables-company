<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\GradingStudent;

class FileController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        // Validasi file dan id student
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048', // File harus PDF dan maksimal 2MB
            'student_id' => 'required|exists:grading_student,id', // ID harus valid di tabel grading_student
        ]);

        // Simpan file di storage/public/pdf
        $filePath = $request->file('file')->store('pdf', 'public');

        // Simpan path file di kolom laporan_student berdasarkan ID student
        $gradingStudent = GradingStudent::find($request->input('student_id'));
        $gradingStudent->laporan_student = $filePath;
        $gradingStudent->save();

        // Redirect dengan success message
        return redirect()->route('upload-file')->with('filePath', $filePath);
    }

    public function show($filename)
    {
        // Tampilkan file yang sudah di-upload
        $path = storage_path('app/public/pdf/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}
