<?php

namespace App\Filament\Resources\AssignResource\Pages;

use App\Filament\Resources\AssignResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssigns extends ListRecords
{
    protected static string $resource = AssignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
