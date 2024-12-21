<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectDetailResource\Pages;
use App\Filament\Resources\ProjectDetailResource\RelationManagers;
use App\Models\ProjectDetail;
use App\Models\ProjectDetailStatus;
use App\Models\ProjectHead;
use App\Models\ProjectPhase;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Tables\Grouping\Group;

class ProjectDetailResource extends Resource
{
    protected static ?string $model = ProjectDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Projects';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('project_head_id')
                    ->required()
                    ->searchable()
                    ->label('Project')
                    ->options(ProjectHead::all()->mapWithKeys(function ($record) {
                        return [$record->id => "{$record->name} - {$record->company->name}"];
                    }))
                    ->reactive() // ทำให้ Select นี้ส่งค่าแบบทันทีเมื่อเปลี่ยน
                    ->afterStateUpdated(fn($state, callable $set) => $set('project_phase_id', null)), // ล้างค่า phase เมื่อเปลี่ยน project
                Select::make('project_phase_id')
                    ->required()
                    ->label('Project phase')
                    ->options(function (callable $get) {
                        $selectedProjectHeadId = $get('project_head_id');
                        if ($selectedProjectHeadId) {
                            return ProjectPhase::whereDoesntHave('projectDetails', function ($query) use ($selectedProjectHeadId) {
                                $query->where('project_head_id', $selectedProjectHeadId);
                            })
                                ->orderBy('id', 'asc') // เพิ่มการเรียงลำดับตาม id
                                ->pluck('name', 'id');
                        }
                        return []; // คืนค่าว่างถ้าไม่ได้เลือก project_head
                    })
                    ->hidden(fn($operation) => $operation === 'edit'),
                Select::make('project_phase_id')
                    ->required()
                    ->label('Project phase')
                    ->options(ProjectPhase::all()->pluck('name', 'id'))
                    ->hidden(fn($operation) => $operation === 'create'),
                // เงื่อนไขแสดง start_date และ end_date เฉพาะในหน้า Edit
                Forms\Components\DatePicker::make('start_date')
                    ->required()
                    ->hidden(fn($operation) => $operation === 'create'),
                Forms\Components\DatePicker::make('end_date')
                    ->required()
                    ->hidden(fn($operation) => $operation === 'create'),
                Forms\Components\DatePicker::make('actual_start_date')
                    ->hidden(fn($operation) => $operation === 'create'),
                Forms\Components\DatePicker::make('actual_end_date')
                    ->hidden(fn($operation) => $operation === 'create'),
                Select::make('status_id')
                    ->required()
                    ->label('Project status')
                    ->options(ProjectDetailStatus::all()->pluck('name', 'id')),
                TextInput::make('days')
                    ->hidden(fn($operation) => $operation === 'edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // ->defaultSort('id', 'desc')
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
                    ->label('Id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('project_head.name')
                    ->label('Project')
                    ->searchable()
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
                Tables\Columns\TextColumn::make('actual_start_date')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('actual_end_date')
                    ->date('d/m/Y')
                    ->sortable(),
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->groups(
                [
                    Group::make('project_head.name')
                        ->label('Project')
                ]
            );
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
