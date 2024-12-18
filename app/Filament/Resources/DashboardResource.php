<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DashboardResource\Pages;
use App\Models\ProjectDetail;
use App\Models\ProjectHead;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Filters\Filter;
use App\Tables\Columns\ProgressColumn;

class DashboardResource extends Resource
{
    protected static ?string $model = ProjectHead::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $breadcrumb = 'Dashboard';
    protected static ?string $pluralLabel = 'Dashboard';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                ProjectHead::query()
                    ->selectRaw('*, (end_date::date - start_date::date + 1) as duration')
            )
            ->defaultSort("id", 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ImageColumn::make('logo')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assign.name')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('request_by')
                    ->sortable()
                    ->searchable()
                    ->badge(),
                Tables\Columns\TextColumn::make('status.name')
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'รอการอนุมัติ' => 'warning',
                        'อนุมัติแล้ว' => 'success',
                    }),
                Tables\Columns\TextColumn::make('start_date')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('end_date')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Duration')
                    ->badge()
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state . ' days'),
                ProgressColumn::make('progress')
                    ->default(function ($record) {
                        // dd($record->id);
                        $project_details = ProjectDetail::where('project_head_id', $record->id)->get();
                        if ($project_details->isNotEmpty()) {
                            $count = $project_details->count();
                            $percent = 100 / $count;
                            $total_percent = 0;

                            foreach ($project_details as $project_detail) {
                                if ($project_detail->status->id == 3) {
                                    $total_percent += $percent;
                                }
                            }

                            return $total_percent;
                        }
                        return 0;
                        // dd($project_details);
                    }),
                // Tables\Columns\ImageColumn::make('images'),
            ])
            ->filters([
                Filter::make('Year')
                    ->form([
                        Select::make('year_from')
                            ->label('From Year')
                            ->options(
                                ProjectHead::query()
                                    ->selectRaw('DISTINCT EXTRACT(YEAR FROM start_date) as year')
                                    ->orderBy('year', 'desc')
                                    ->pluck('year', 'year')
                                    ->toArray()
                            )
                            ->placeholder('Select Start Year'),
                        Select::make('year_to')
                            ->label('To Year')
                            ->options(
                                ProjectHead::query()
                                    ->selectRaw('DISTINCT EXTRACT(YEAR FROM start_date) as year')
                                    ->orderBy('year', 'desc')
                                    ->pluck('year', 'year')
                                    ->toArray()
                            )
                            ->placeholder('Select End Year'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['year_from'],
                                fn($query, $year) => $query->whereYear('start_date', '>=', $year)
                            )
                            ->when(
                                $data['year_to'],
                                fn($query, $year) => $query->whereYear('start_date', '<=', $year)
                            );
                    })
            ])
            ->actions([
                Action::make('View')
                    ->button()
                    ->icon('heroicon-o-eye')
                    ->url(fn(ProjectHead $record): string => self::getUrl('view', ['record' => $record->id]))
                // ->openUrlInNewTab()
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListDashboards::route('/'),
            'view' => Pages\ViewDashboard::route('/{record}'),
            'remarks' => Pages\Remarks::route('/{record}/remarks'),
            // 'detail' => Pages\DetailDashboard::route('/{record}/detail'),
            // 'edit' => Pages\EditDashboard::route('/{record}/edit'),
        ];
    }
}
