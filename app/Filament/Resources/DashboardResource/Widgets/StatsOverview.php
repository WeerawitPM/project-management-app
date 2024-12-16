<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\ProjectHead;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Support\Enums\IconPosition;

class StatsOverview extends BaseWidget
{
    protected static bool $isLazy = false;
    
    protected function getStats(): array
    {
        $waiting = ProjectHead::whereHas('status', function ($query) {
            $query->where('name', 'รอการอนุมัติ');
        })->get()->count();

        $approved = ProjectHead::whereHas('status', function ($query) {
            $query->where('name', 'อนุมัติแล้ว');
        })->get()->count();

        $all = ProjectHead::all()->count();

        return [
            Stat::make('Waiting', $waiting)
                ->description('Waiting project status')
                ->descriptionIcon('heroicon-m-clock', IconPosition::Before)
                ->color('warning')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('Approved', $approved)
                ->description('Approved project status')
                ->descriptionIcon('heroicon-m-check-circle', IconPosition::Before)
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('All Project', $all)
                ->description('All project status')
                ->descriptionIcon('heroicon-m-calendar', IconPosition::Before)
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
        ];
    }
}
