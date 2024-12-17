<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\ProjectDetail;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Filament\Tables\Columns\Summarizers\Sum;

class TableDetail extends BaseWidget
{
    public $id;
    public function mount()
    {
        $this->id = Route::current()->parameter('record'); // Get the ID from the route parameters
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading("")
            ->query(
                ProjectDetail::query()
                    ->selectRaw('*, (end_date::date - start_date::date + 1) as duration')
                    ->where('project_head_id', $this->id)
            )
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('project_head.name')
                    ->label('Project')
                    ->sortable(),
                Tables\Columns\TextColumn::make('project_phase.name')
                    ->label('Phase')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Duration')
                    ->sortable()
                    // ->formatStateUsing(fn ($state) => $state . ' days')
                    ->summarize(
                        Sum::make()
                            ->label('')
                            ->formatStateUsing(fn($state) => $state . ' days')
                    ),
                // ->default(
                //     fn(ProjectDetail $record) => $record->start_date && $record->end_date
                //     ? Carbon::parse($record->start_date)->diffInDays(Carbon::parse($record->end_date)) + 1
                //     : "N/A"
                // ),
                Tables\Columns\TextColumn::make('status.name')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'ยังไม่ดำเนินการ' => 'gray',
                        'กำลังดำเนินการ' => 'warning',
                        'ดำเนินการเสร็จสิ้น' => 'success',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }
}
