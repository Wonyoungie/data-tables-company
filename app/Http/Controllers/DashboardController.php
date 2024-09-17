<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $StudentData = User::selectRaw('
        MONTH(created_at) as month,
        YEAR(created_at) as year,
        COUNT(CASE WHEN type = "member" THEN 1 END) as students
        ')

        ->groupBy('month', 'year')
            ->get();

        $PartnerData = DB::table('m_partner')->selectRaw('
        COUNT(CASE WHEN type = "UNIVERSITY" THEN 1 END) as universities,
        COUNT(CASE WHEN type = "COMPANY" THEN 1 END) as companies,
        COUNT(CASE WHEN type = "GOVERNMENT" THEN 1 END) as governments
        ')

        ->get();

        // Kirim data ke view
        return view('pages.dashboard', [
            'StudentData' => $StudentData,
            'PartnerData' => $PartnerData,
        ]);
    }
}
