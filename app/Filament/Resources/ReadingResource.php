<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReadingResource\Pages;
use App\Filament\Resources\ReadingResource\RelationManagers;
use App\Filament\Resources\ReadingsResource\Widgets\Flow;
use App\Models\Reading;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Date;

class ReadingResource extends Resource
{

    protected static ?string $model = Reading::class;
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-vertical';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll()
            ->defaultPaginationPageOption(50)
            ->paginationPageOptions([10, 25, 50, 100, 250, 500])
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Recorded At')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                ,
                Tables\Columns\TextColumn::make('source_id')
                    ->label('Source IP')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('flow')
                    ->summarize([
                        Tables\Columns\Summarizers\Range::make(),
                        Tables\Columns\Summarizers\Average::make(),
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('accumulative_flow')
                    ->summarize([
                        Tables\Columns\Summarizers\Range::make(),
                        Tables\Columns\Summarizers\Average::make(),
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('pressure')
                    ->summarize([
                        Tables\Columns\Summarizers\Range::make(),
                        Tables\Columns\Summarizers\Average::make(),
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('temperature')
                    ->summarize([
                        Tables\Columns\Summarizers\Range::make(),
                        Tables\Columns\Summarizers\Average::make(),
                    ])
                    ->sortable(),
                 Tables\Columns\TextColumn::make('status')
                    ->sortable(),
                Tables\Columns\TextColumn::make('standby')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('date')
                    ->columns()
                    ->columnSpan(2)
                    ->form([
                        Forms\Components\DateTimePicker::make('from')
                            ->default(now()->subHours(12)->toDateTimeString())
                            ->maxDate(fn (Get $get): string => $get('to')),
                        Forms\Components\DateTimePicker::make('to')
                            ->formatStateUsing(fn (string $state): string => Date::parse($state)
                                ->endOfDay()
                                ->toDateTimeString())
                            ->minDate(fn (Get $get): string => $get('from'))
                            ->maxDate(now()->endOfDay())
                            ->default(now()->endOfDay()),
                    ])
                    ->query(
                        static fn (Builder $query, array $data): Builder => $query
                            ->whereBetween('created_at', $data)
                    ),
//                Tables\Filters\SelectFilter::make('group_by_time')
//                    ->label('Group By Time')
//                    ->options([
//                        'second' => 'Second',
//                        'minute' => 'Minute',
//                        'hour' => 'Hour',
//                    ])
//                    ->default('second')
//                ->query(
//                    static fn (Builder $query, array $data): Builder =>
//                        match($data['value']) {
//                            'hour' => $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:00:00') as created_at, AVG(flow) as flow, AVG(accumulative_flow) as accumulative_flow, AVG(status) as status, AVG(pressure) as pressure, AVG(temperature) as temperature, AVG(standby) as standby")->groupByRaw("hour( created_at ) , day( created_at ), month( created_at )"),
//                            'minute' => $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:00') as created_at, AVG(flow) as flow, AVG(accumulative_flow) as accumulative_flow, AVG(status) as status, AVG(pressure) as pressure, AVG(temperature) as temperature, AVG(standby) as standby")->groupByRaw("minute ( created_at ) , hour( created_at ) , day( created_at ), month( created_at )"),
//                            'second' => $query,
//                        }
//                )
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReadings::route('/'),
        ];
    }

    public static function canView(Model $record): bool
    {
        return false;
    }

     public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canCreate(): bool
    {
        return false; // TODO: Change the autogenerated stub
    }
}
