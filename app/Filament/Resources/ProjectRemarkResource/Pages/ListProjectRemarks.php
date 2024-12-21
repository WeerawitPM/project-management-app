<?php

namespace App\Filament\Resources\ProjectRemarkResource\Pages;

use App\Filament\Resources\ProjectRemarkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectRemarks extends ListRecords
{
    protected static string $resource = ProjectRemarkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                // ->mutateFormDataUsing(function (array $data): array {
                //     $saveData = [];
                //     dd($data);
                //     return $data;
                // }),
        ];
    }
}
