<?php

namespace App\Http\Controllers;

use App\Imports\TravelRatingsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TravelController extends Controller
{

    public function show_import_form()
    {
        return view('test');
    }

    public function import(Request $request)
    {
        Excel::toCollection(
            new TravelRatingsImport(),
            $request->file
        )[0];
    }
}
