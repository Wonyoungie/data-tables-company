<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MPartner;
use App\Models\GradingStudent;
use Exception;

class CompanyController extends Controller
{
    public function index()
    {
        try {
            $dataGrade = GradingStudent::with('user', 'm_partner')->get();

            return view('pages.company.index', [
                'students' => $dataGrade,
            ]);
        } catch (Exception $error) {
        }

        return view('pages.company.index');
    }

    public function updateGrade(Request $request)
{
    // Hapus sementara validasi untuk debugging
    // $request->validate([ ... ]);

    // Temukan student berdasarkan user_id
    $student = GradingStudent::where('id', $request->id)->first();

    if ($student) {
        // Perbarui grade
        $student->grade = $request->grade;
        $student->save();

        return redirect()->route('getCompany')->with('success', 'Grade updated successfully.');
    } else {
        // Redirect kembali dengan pesan error
        return redirect()->route('getCompany')->with('error', 'Student not found.');
    }
}


    
    public function getPartners () {

        return view('', [
            'partners'
        ]);
    }
}
