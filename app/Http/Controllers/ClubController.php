<?php

namespace App\Http\Controllers;

use App\Http\Resources\Clubs\ClubsIndexResource;
use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function index()
    {
        return response()->json(
            ClubsIndexResource::collection(Club::all())
        );
    }
}
