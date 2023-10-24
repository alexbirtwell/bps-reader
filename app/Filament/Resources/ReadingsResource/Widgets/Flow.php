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
                'backgroundColor' => '#F85DC6',
                'borderColor' => '#F85DC6',
                'pointBackgroundColor' => '#F85DC6',
                'data' => $data->map(fn ($record) => (int) $record->flow),
            ],
            [
                'label' => 'Accumulative Flow',
                'backgroundColor' => '#7F4CFD',
                'borderColor' => '#7F4CFD',
                'pointBackgroundColor' => '#7F4CFD',
                'data' => $data->map(fn ($record) => (int) $record->accumulative_flow),
            ],
            [

                'label' => 'Pressure',
                'backgroundColor' => '#40BEE5',
                'borderColor' => '#40BEE5',
                'pointBackgroundColor' => '#40BEE5',
                'data' => $data->map(fn ($record) => (int) $record->pressure),
            ],
            [
                'label' => 'Temperature',
                'backgroundColor' => '#FDCC2E',
                'borderColor' => '#FDCC2E',
                'pointBackgroundColor' => '#FDCC2E',
                'data' => $data->map(fn ($record) => (int) $record->temperature),
            ],
            [
                'label' => 'Status',
                'backgroundColor' => '#CEF217',
                'borderColor' => '#CEF217',
                'pointBackgroundColor' => '#CEF217',#CEF217
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
