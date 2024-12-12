<?php

namespace App\Filament\Resources\ProjectDetailStatusResource\Pages;

use App\Filament\Resources\ProjectDetailStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectDetailStatus extends EditRecord
{
    protected static string $resource = ProjectDetailStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
