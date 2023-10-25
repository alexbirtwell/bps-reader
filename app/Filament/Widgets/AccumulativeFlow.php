<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ReadingResource\Pages\ListReadings;
use App\Models\Reading;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class AccumulativeFlow extends ChartWidget
{
    use InteractsWithPageTable;

    protected static ?string $heading = 'Accumulative Flow';
    protected static ?string $description = 'From the last 30 minutes';
    protected int | string | array $columnSpan = "1";

   protected function getData(): array
    {
    $data = Reading::where('created_at', '>=', now()->subMinutes(30))
        ->orderBy('created_at', 'asc')
        ->get();

    return [
        'datasets' => [
            [
                'label' => 'Accumulative Flow',
                'backgroundColor' => config('readings.colors.accumulative_flow'),
                'borderColor' => config('readings.colors.accumulative_flow'),
                'pointBackgroundColor' => config('readings.colors.accumulative_flow'),
                'data' => $data->map(fn ($record) => (int) $record->accumulative_flow),
            ],
        ],
        'labels' => $data->map(fn ($record) => $record->created_at->format('H:i')),
    ];
}

    protected function getType(): string
    {
        return 'line';
    }

    protected function getTablePage(): string
    {
        return ListReadings::class;
    }
}
