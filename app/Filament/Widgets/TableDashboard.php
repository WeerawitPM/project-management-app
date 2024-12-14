<?php

namespace App\Filament\Widgets;

use App\Models\ProjectHead;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TableDashboard extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->heading("")
            ->query(
                ProjectHead::query()
            )
            ->defaultSort("id", 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('assign.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status.name')
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'รอการอนุมัติ' => 'warning',
                        'อนุมัติแล้ว' => 'success',
                    }),
                Tables\Columns\TextColumn::make('start_date')->date()->sortable(),
                Tables\Columns\TextColumn::make('end_date')->date()->sortable(),
                // Tables\Columns\ImageColumn::make('images'),
            ])
            ->actions([
                Action::make('View')
                    ->button(),
                Action::make('Detail')
                    ->button()
                    ->url(fn(ProjectHead $record): string => 'detail')
                    ->openUrlInNewTab()
            ]);
    }
}
