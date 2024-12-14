<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Detail extends Page
{
    protected static string $resource = Dashboard::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.detail';
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
