<?php

namespace App\Filament\Resources\ProjectHeadResource\Pages;

use App\Filament\Resources\ProjectHeadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectHeads extends ListRecords
{
    protected static string $resource = ProjectHeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
