<?php

namespace App\Filament\Resources\ProjectStatusNewOldResource\Pages;

use App\Filament\Resources\ProjectStatusNewOldResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectStatusNewOlds extends ListRecords
{
    protected static string $resource = ProjectStatusNewOldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
