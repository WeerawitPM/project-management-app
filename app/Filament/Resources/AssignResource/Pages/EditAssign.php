<?php

namespace App\Filament\Resources\AssignResource\Pages;

use App\Filament\Resources\AssignResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAssign extends EditRecord
{
    protected static string $resource = AssignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
