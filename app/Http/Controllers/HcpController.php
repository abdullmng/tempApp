<?php

namespace App\Http\Controllers;

use App\Models\Hcp;
use Illuminate\Http\Request;

class HcpController extends Controller
{
    public function getByOrganisation($organisation_id)
    {
        $hcps = Hcp::where('organisation_id', $organisation_id)->get();
        return response()->json($hcps);
    }
}
