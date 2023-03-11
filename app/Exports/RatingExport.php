<?php

namespace App\Exports;

use App\Models\RatingPointCategory;
use App\Services\Rating\Rating;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RatingExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    use Exportable;

    protected CarbonPeriod $period;
    protected $categories;

    public function __construct(CarbonPeriod $period)
    {
        $this->period = $period;
        $this->categories = $this->getCategories();
    }

    public function title(): string
    {
        if ($this->period->start->equalTo($this->period->end)) {
            return Str::lower($this->period->start->isoFormat('MMMMYYYY'));
        }

        return Str::lower($this->period->start->isoFormat('MMMMYYYY') . ' - ' . $this->period->end->isoFormat('MMMMYYYY'));
    }

    public function collection()
    {
        $rating = (new Rating())->setPeriod($this->period)->getQueryWithPeriod()
            ->select([
                'id',
                'rating_point_category_id',
                'user_id',
                DB::raw('SUM(amount) as amount')
            ])
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'name');
                },
                'category' => function ($query) {
                    $query->select('id', 'name');
                }
            ])
            ->groupBy('user_id', 'rating_point_category_id')
            ->get()
            ->groupBy('user.name')->map->keyBy('rating_point_category_id');

        return $rating->map([$this, 'map']);
    }

    public function map(Collection $points, string $name): array
    {
        return array_merge(
            [
                $name,
                $points->sum('amount')
            ],
            $this->categories->map(function ($category) use ($points) {
                return $points[$category['id']]->amount ?? 0;
            })->toArray()
        );
    }

    public function headings(): array
    {
        return [
            array_merge(
                [
                    'Фамилия, Имя',
                    'Всего очков',
                ],
                $this->categories->map->name->toArray()
            )
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:Z1')->getAlignment()->setTextRotation(90);

        $sheet->getDefaultColumnDimension()->setWidth(6);
        $sheet->getColumnDimension('A')->setWidth(23);
    }

    protected function getCategories()
    {
        return RatingPointCategory::select('id', 'name')->get()->map(function (RatingPointCategory $category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
            ];
        });
    }
}
