<?php

namespace App\Filament\Widgets;

use App\Models\Reading;
use Closure;
use Filament\Support\Concerns\HasHeading;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Contracts\Support\Htmlable;

class CurrentReadings extends BaseWidget
{
    protected int | string | array $columnSpan = "full";
    protected string | Htmlable | Closure | null $heading = 'Current Readings';
    protected function getStats(): array
    {
        $data = Reading::orderBy('created_at', 'desc')->first();
        $secondaryData = Reading::orderBy('created_at', 'desc')->skip(30)->first();

        return [
            Stat::make('Flow', $data->flow)->color(config('readings.colors.flow'))->description($secondaryData->flow),
            Stat::make('Accumulative Flow', $data->accumulative_flow)->color(config('readings.colors.accumulative_flow'))->description($secondaryData->accumulative_flow),
            Stat::make('Pressure', $data->pressure)->color(config('readings.colors.pressure'))->description($secondaryData->pressure),
            Stat::make('Temperature', $data->temperature)->color(config('readings.colors.temperature'))->description($secondaryData->temperature),
            Stat::make('Status', $data->status)->color(config('readings.colors.status'))->description($secondaryData->status),
            Stat::make('Pressure', $data->standby)->color(config('readings.colors.standby'))->description($secondaryData->standby),
        ];
    }
}
