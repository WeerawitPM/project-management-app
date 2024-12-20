<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectRemarkResource\Pages;
use App\Filament\Resources\ProjectRemarkResource\RelationManagers;
use App\Models\ProjectDetail;
use App\Models\ProjectHead;
use App\Models\ProjectRemark;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\RichEditor;

class ProjectRemarkResource extends Resource
{
    protected static ?string $model = ProjectRemark::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Projects';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('project_detail_id')
                    ->searchable()
                    ->required()
                    ->label('Project')
                    ->columnSpanFull()
                    ->options(ProjectDetail::all()->mapWithKeys(function ($record) {
                        return [$record->id => "{$record->project_head->name} - {$record->project_phase->name}"];
                    })),
                RichEditor::make('remark')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('start_date')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                // ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('project_detail.project_head.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('project_detail.project_phase.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('remark')
                    ->html()
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
            ])
            // ->groups(
            //     [
            //         Group::make('project_head.name')
            //             ->label('Project')
            //     ]
            // );
        ;
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
            'index' => Pages\ListProjectRemarks::route('/'),
            // 'create' => Pages\CreateProjectRemark::route('/create'),
            // 'edit' => Pages\EditProjectRemark::route('/{record}/edit'),
        ];
    }
}
