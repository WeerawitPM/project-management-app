<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectHeadResource\Pages;
use App\Filament\Resources\ProjectHeadResource\RelationManagers;
use App\Models\Assign;
use App\Models\Company;
use App\Models\ProjectHead;
use App\Models\ProjectStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;

class ProjectHeadResource extends Resource
{
    protected static ?string $model = ProjectHead::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Select::make('company_id')
                    ->required()
                    ->label('Company')
                    ->options(Company::all()->pluck('name', 'id')),
                Select::make('assign_id')
                    ->required()
                    ->label('Assign')
                    ->options(Assign::all()->pluck('name', 'id')),
                Select::make('status_id')
                    ->required()
                    ->label('Status')
                    ->options(ProjectStatus::all()->pluck('name', 'id')),
                Forms\Components\DatePicker::make('start_date')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                // ->required(),
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assign.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
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
            'index' => Pages\ListProjectHeads::route('/'),
            // 'create' => Pages\CreateProjectHead::route('/create'),
            // 'edit' => Pages\EditProjectHead::route('/{record}/edit'),
        ];
    }
}
