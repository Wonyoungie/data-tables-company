<?php

namespace App\Http\Controllers;

use App\Models\MPartner;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    // Get all latest statistic
    public function index()
    {
        $dateNow = Carbon::now();

        return view('pages.dashboard', [
            "fetched_date"   => $dateNow,
            "total_student" => User::count(),
            "total_company" => MPartner::where('type', '=', 'COMPANY')->count(),
            "total_university" => MPartner::where('type', '=', 'UNIVERSITY')->count(),
            "total_government" => MPartner::where('type', '=', 'GOVERNMENT')->count(),
            "total_student_project_completed" => MPartner::where('type', '=', 'GOVERNMENT')->count(),
        ]);
    }

}
