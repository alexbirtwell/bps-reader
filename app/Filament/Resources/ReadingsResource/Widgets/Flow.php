<?php

namespace App\Filament\Resources\ReadingsResource\Widgets;

use App\Filament\Resources\ReadingResource\Pages\ListReadings;
use App\Models\Reading;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class Flow extends ChartWidget
{
    use InteractsWithPageTable;

    protected static ?string $heading = 'Flow';
    protected int | string | array $columnSpan = "full";

   protected function getData(): array
    {
    $data = $this->getPageTableRecords();

    return [
        'datasets' => [
            [
                'label' => 'Flow',
                'backgroundColor' => config('readings.colors.flow'),
                'borderColor' => config('readings.colors.flow'),
                'pointBackgroundColor' => config('readings.colors.flow'),
                'data' => $data->map(fn ($record) => (int) $record->flow),
            ],
            [
                'label' => 'Accumulative Flow',
                'backgroundColor' => config('readings.colors.accumulative_flow'),
                'borderColor' => config('readings.colors.accumulative_flow'),
                'pointBackgroundColor' => config('readings.colors.accumulative_flow'),
                'data' => $data->map(fn ($record) => (int) $record->accumulative_flow),
            ],
            [

                'label' => 'Pressure',
                'backgroundColor' => config('readings.colors.pressure'),
                'borderColor' => config('readings.colors.pressure'),
                'pointBackgroundColor' => config('readings.colors.pressure'),
                'data' => $data->map(fn ($record) => (int) $record->pressure),
            ],
            [
                'label' => 'Temperature',
                'backgroundColor' => config('readings.colors.temperature'),
                'borderColor' => config('readings.colors.temperature'),
                'pointBackgroundColor' => config('readings.colors.temperature'),
                'data' => $data->map(fn ($record) => (int) $record->temperature),
            ],
            [
                'label' => 'Status',
                'backgroundColor' => config('readings.colors.status'),
                'borderColor' => config('readings.colors.status'),
                'pointBackgroundColor' => config('readings.colors.status'),#CEF217
                'data' => $data->map(fn ($record) => (int) $record->pressure),
            ],
        ],
        'labels' => $data->map(fn ($record) => $record->created_at->format('m-d H:i:s')),
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
