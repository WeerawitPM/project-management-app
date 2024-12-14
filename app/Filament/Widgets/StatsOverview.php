<?php

namespace App\Filament\Widgets;

use App\Models\ProjectHead;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
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
            Stat::make('Waiting', $waiting),
            Stat::make('Approved', $approved),
            Stat::make('All Project', $all),
        ];
    }
}
