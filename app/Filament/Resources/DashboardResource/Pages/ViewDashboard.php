<?php

namespace App\Filament\Resources\DashboardResource\Pages;

use App\Filament\Resources\DashboardResource;
use App\Models\ProjectHead;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Filament\Infolists\Components\ImageEntry;

class ViewDashboard extends Page
{
    protected static string $resource = DashboardResource::class;
    protected static string $view = 'filament.resources.dashboard-resource.pages.view-dashboard';
    // protected static ?string $breadcrumb = 'View';
    protected static ?string $pluralLabel = 'View Project';
    protected static ?string $title = 'View Project';
    protected static ?string $breadcrumb = 'View Project';
    // public function getBreadcrumb(): ?string
    // {
    //     return null;
    // }

    public $data = [];
    public function mount()
    {
        $this->id = Route::current()->parameter('record');
        $projectHead = ProjectHead::with('company', 'assign', 'status')->where('id', $this->id)->first();
        if ($projectHead) {
            $data = $projectHead->toArray();

            // Format dates to "วัน/เดือน/ปี"
            $data['start_date'] = $projectHead->start_date
                ? Carbon::parse($projectHead->start_date)->format('d/m/Y')
                : null;

            $data['end_date'] = $projectHead->end_date
                ? Carbon::parse($projectHead->end_date)->format('d/m/Y')
                : null;

            $this->data = $data;
        }
        // dd($this->data['images']);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('View Remarks')
                ->icon('heroicon-o-eye')
                ->url(DashboardResource::getUrl('remarks', ['record' => $this->data['id']]))
                ->openUrlInNewTab(),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make()
                ->columns(2)
                ->schema([
                    TextInput::make("data.name")
                        ->label('Project Name')
                        ->readOnly(),
                    TextInput::make('data.company.name')
                        ->label('Company')
                        ->readOnly(),
                    TextInput::make('data.assign.name')
                        ->label('Assigned To')
                        ->readOnly(),
                    TextInput::make('data.status.name')
                        ->label('Status')
                        ->readOnly(),
                    TextInput::make('data.start_date')
                        ->label('Start Date')
                        ->readOnly(),
                    TextInput::make('data.end_date')
                        ->label('End Date')
                        ->readOnly(),
                ]),
        ];
    }
}
