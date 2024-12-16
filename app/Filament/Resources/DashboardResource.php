<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DashboardResource\Pages;
use App\Models\ProjectHead;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

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
                Tables\Columns\TextColumn::make('start_date')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('end_date')->date('d/m/Y')->sortable(),
                // Tables\Columns\ImageColumn::make('images'),
            ])
            ->filters([
                //
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
