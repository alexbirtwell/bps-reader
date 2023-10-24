<?php

namespace App\Filament\Resources\ReadingResource\Pages;

use App\Filament\Resources\ReadingResource;
use App\Filament\Resources\ReadingsResource\Widgets\Flow;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListReadings extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = ReadingResource::class;
    protected ?string $maxContentWidth = 'full';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Flow::class
        ]; // TODO: Change the autogenerated stub
    }
}
