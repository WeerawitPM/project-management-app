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
use Illuminate\Support\Facades\Auth;

class ProjectHeadResource extends Resource
{
    protected static ?string $model = ProjectHead::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Projects';
    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        // ตรวจสอบว่า user ที่ล็อกอินมี role เป็น 'user' หรือไม่
        return !Auth::user()->hasRole('user');
    }

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
                Forms\Components\DatePicker::make('end_date'),
                // ->required(),
                Forms\Components\FileUpload::make('images')
                    ->columnSpanFull()
                    ->image()
                    ->multiple() // เพิ่มบรรทัดนี้เพื่อรองรับการอัปโหลดหลายไฟล์
                    ->imageEditor()
                    ->directory('images'),
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
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
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
                Tables\Columns\ImageColumn::make('images'),
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
