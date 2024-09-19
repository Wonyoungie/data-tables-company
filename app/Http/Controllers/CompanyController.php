<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MPartner;
use App\Models\GradingStudent;
use Exception;

class CompanyController extends Controller
{
    public function index(Request $request)
{
    try {
        // Ambil data grading_student beserta relasi user dan m_partner
        $query = GradingStudent::with('user', 'm_partner');
        
        // Filter berdasarkan status 'UNVERIFIED' jika parameter 'unverified' ada
        if ($request->has('unverified') && $request->unverified == 'true') {
            $query->where('status', 'UNVERIFIED');
        }

        $dataGrade = $query->get()
            ->map(function ($student) {
                // Hitung jumlah laporan yang sudah terisi (tidak null)
                $filledReports = 0;
                if ($student->laporan_bulan1) $filledReports++;
                if ($student->laporan_bulan2) $filledReports++;
                if ($student->laporan_bulan3) $filledReports++;
                if ($student->laporan_bulan4) $filledReports++;
                if ($student->laporan_student) $filledReports++;

                // Simpan progress dalam properti tambahan
                $student->progress = $filledReports; // Total laporan yang terisi dari 5
                return $student;
            });

        return view('pages.company.index', [
            'students' => $dataGrade,
        ]);
    } catch (Exception $error) {
        // Kamu bisa tambahkan handling error di sini jika diperlukan
        return view('pages.company.index')->withErrors(['error' => $error->getMessage()]);
    }
}

public function show($id)
{
    $student = GradingStudent::with('user', 'm_partner')->findOrFail($id);

    return view('pages.company.detail', [
        'student' => $student,
    ]);
}


public function updateGrade(Request $request)
{
    // Hapus sementara validasi untuk debugging
    // $request->validate([ ... ]);

    // Temukan student berdasarkan ID
    $student = GradingStudent::where('id', $request->id)->first();

    if ($student) {
        // Perbarui grade
        $student->grade = $request->grade;

        // Set status menjadi PENDING
        $student->status = 'PENDING';

        // Hapus catatan
        $student->note = '';

        // Simpan perubahan ke database
        $student->save();

        // Redirect dengan pesan sukses
        return redirect()->route('getCompany')->with('success', 'Grade updated successfully.');
    } else {
        // Redirect dengan pesan error jika student tidak ditemukan
        return redirect()->route('getCompany')->with('error', 'Student not found.');
    }
}

// Method untuk menampilkan PDF
public function showReport($filename)
{
    $path = storage_path('app/public/pdf/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
}
    
    public function getPartners () {

        return view('', [
            'partners'
        ]);
    }
}
