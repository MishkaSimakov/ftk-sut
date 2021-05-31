<?php

namespace App\Http\Controllers;

use App\Exports\RatingExport;
use App\Http\Requests\Ratings\RatingDestroyRequest;
use App\Models\RatingPoint;
use App\Services\Rating\Rating;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(RatingPoint::class);
    }

    protected function resourceMethodsWithoutModels(): array
    {
        return ['index', 'create', 'store', 'destroy'];
    }

    public function index()
    {
        return view('ratings.index');
    }

    public function create()
    {
        return view('ratings.create');
    }

    public function store(Request $request)
    {
        (new Rating())->store(
            Carbon::parse($request->get('date')),
            $request->file('rating')
        );

        return redirect()->route('rating.index');
    }

    public function showDestroyPage()
    {
        $this->authorize('delete', RatingPoint::class);

        return view('ratings.destroy');
    }

    public function destroy(RatingDestroyRequest $request)
    {
        (new Rating())->setPeriodStartFromString($request->get('date_start'))
            ->setPeriodEndFromString($request->get('date_end'))->destroy();

        return redirect()->route('rating.index');
    }

    public function export(CarbonPeriod $period)
    {
        $this->authorize('export', RatingPoint::class);

        return (new RatingExport($period))->download('rating.xlsx');
    }
}
