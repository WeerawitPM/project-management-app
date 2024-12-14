<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\TableDashboard;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';
}
