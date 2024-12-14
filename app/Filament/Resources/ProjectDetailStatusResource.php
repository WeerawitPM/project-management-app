<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectDetailStatusResource\Pages;
use App\Filament\Resources\ProjectDetailStatusResource\RelationManagers;
use App\Models\ProjectDetailStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectDetailStatusResource extends Resource
{
    protected static ?string $model = ProjectDetailStatus::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->numeric(),
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
                    ->searchable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'ยังไม่ดำเนินการ' => 'gray',
                        'กำลังดำเนินการ' => 'warning',
                        'ดำเนินการเสร็จสิ้น' => 'success',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->numeric()
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
            'index' => Pages\ListProjectDetailStatuses::route('/'),
            // 'create' => Pages\CreateProjectDetailStatus::route('/create'),
            // 'edit' => Pages\EditProjectDetailStatus::route('/{record}/edit'),
        ];
    }
}
