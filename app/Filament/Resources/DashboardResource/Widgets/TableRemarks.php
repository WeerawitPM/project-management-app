<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\ProjectRemark;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Route;

class TableRemarks extends BaseWidget
{
    public $id;

    public function mount()
    {
        $this->id = Route::current()->parameter('record'); // Get the ID from the route parameters
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('project_head_id')
                    ->label('Project'),
                RichEditor::make('remark')
                    ->columnSpanFull(),
                TextInput::make('start_date'),
                TextInput::make('end_date')
                // ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading("")
            ->query(
                ProjectRemark::query()->where('project_head_id', $this->id)
            )
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
                Tables\Columns\TextColumn::make('start_date')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('remark')
                    ->label('Remark')
                    ->html(),

            ])
            ->filters([
                //
            ])
            ->actions([
                // ViewAction::make('View')
                //     ->button()
                //     ->color('primary')
                //     ->modalHeading('Remark Details')
                //     ->form([
                //         RichEditor::make('remark')
                //             ->label('Remark')
                //     ]),
            ]);
    }
}
