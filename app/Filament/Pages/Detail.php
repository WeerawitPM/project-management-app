<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Route;

class Detail extends Page
{
    protected static string $resource = Dashboard::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.detail';
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public $id; // Property to hold the ID

    // Override the mount method to access the request
    public function mount()
    {
        $this->id = Route::current()->parameter('record'); // Get the ID from the route parameters
    }
}
