<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ReadingResource\Pages\ListReadings;
use App\Models\Reading;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class Pressure extends ChartWidget
{
    use InteractsWithPageTable;

    protected static ?string $heading = 'Pressure';
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

                'label' => 'Pressure',
                'backgroundColor' => config('readings.colors.pressure'),
                'borderColor' => config('readings.colors.pressure'),
                'pointBackgroundColor' => config('readings.colors.pressure'),
                'data' => $data->map(fn ($record) => (int) $record->pressure),
            ]
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
