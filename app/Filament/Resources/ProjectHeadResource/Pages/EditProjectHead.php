<?php

namespace App\Filament\Resources\ProjectHeadResource\Pages;

use App\Filament\Resources\ProjectHeadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectHead extends EditRecord
{
    protected static string $resource = ProjectHeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
