<?php

namespace App\Filament\Resources\ProjectDetailStatusResource\Pages;

use App\Filament\Resources\ProjectDetailStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectDetailStatuses extends ListRecords
{
    protected static string $resource = ProjectDetailStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
