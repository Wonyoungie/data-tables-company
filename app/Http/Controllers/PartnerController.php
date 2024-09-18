<?php

namespace App\Http\Controllers;

use App\Models\MPartner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function getAllPartner() {

        return view('', [
            'allUniversity' => $this->getPartnerUniversity(),
            'allCompany' => $this->getPartnerCompany(),
            'allGovernment' => $this->getPartnerGovernment()
        ]);
    }

    public function getPartnerUniversity()
    {
        return MPartner::where('type', '=', 'UNIVERSITY');
    }

    public function getPartnerCompany()
    {
        return MPartner::where('type', '=', 'COMPANY');
    }

    public function getPartnerGovernment()
    {
        return MPartner::where('type', '=', 'GOVERNMENT');
    }
}
