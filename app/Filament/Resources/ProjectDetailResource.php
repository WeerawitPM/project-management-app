<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectDetailResource\Pages;
use App\Filament\Resources\ProjectDetailResource\RelationManagers;
use App\Models\ProjectDetail;
use App\Models\ProjectDetailStatus;
use App\Models\ProjectHead;
use App\Models\ProjectPhase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;

class ProjectDetailResource extends Resource
{
    protected static ?string $model = ProjectDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('project_head_id')
                    ->required()
                    ->label('Project')
                    ->options(ProjectHead::all()->pluck('name', 'id')),
                Select::make('project_phase_id')
                    ->required()
                    ->label('Project phase')
                    ->options(ProjectPhase::all()->pluck('name', 'id')),
                Forms\Components\DatePicker::make('start_date')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->required(),
                Select::make('status_id')
                    ->required()
                    ->label('Project status')
                    ->options(ProjectDetailStatus::all()->pluck('name', 'id')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status.name')
                    ->label('Status')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
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
            'index' => Pages\ListProjectDetails::route('/'),
            // 'create' => Pages\CreateProjectDetail::route('/create'),
            // 'edit' => Pages\EditProjectDetail::route('/{record}/edit'),
        ];
    }
}
