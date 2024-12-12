<?php

namespace App\Filament\Resources\ProjectRemarkResource\Pages;

use App\Filament\Resources\ProjectRemarkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectRemark extends EditRecord
{
    protected static string $resource = ProjectRemarkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
