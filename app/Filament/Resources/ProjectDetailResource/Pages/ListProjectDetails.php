<?php

namespace App\Filament\Resources\ProjectDetailResource\Pages;

use App\Filament\Resources\ProjectDetailResource;
use App\Models\ProjectDetail;
use App\Models\ProjectHead;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Carbon\Carbon;

class ListProjectDetails extends ListRecords
{
    protected static string $resource = ProjectDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $saveData = [];
                    switch ($data['project_phase_id']) {
                        case 1:
                            $start_date = ProjectHead::where('id', $data['project_head_id'])->first()->start_date;
                            $start_date = Carbon::parse($start_date); // แปลง start_date เป็น Carbon instance
                            $days = (int) $data['days']; // แปลง days เป็นตัวเลข
                            $end_date = $start_date->copy()->addDays($days); // เพิ่มจำนวนวัน
        
                            $saveData['project_head_id'] = $data['project_head_id'];
                            $saveData['project_phase_id'] = $data['project_phase_id'];
                            $saveData['status_id'] = $data['status_id'];
                            $saveData['start_date'] = $start_date->toDateString(); // กลับเป็น string วันที่
                            $saveData['end_date'] = $end_date->toDateString();     // กลับเป็น string วันที่
                            // dd($saveData, $data);
                            break;
                        default:
                            $last_end_date = ProjectDetail::where("project_head_id", $data['project_head_id'])->latest()->first()->end_date;
                            $last_end_date = Carbon::parse($last_end_date); // แปลง last_end_date เป็น Carbon instance
        
                            $start_date = $last_end_date->copy()->addDays(1);
                            $days = (int) $data['days'];
                            $end_date = $start_date->copy()->addDays($days);

                            $saveData['project_head_id'] = $data['project_head_id'];
                            $saveData['project_phase_id'] = $data['project_phase_id'];
                            $saveData['status_id'] = $data['status_id'];
                            $saveData['start_date'] = $start_date->toDateString(); // กลับเป็น string วันที่
                            $saveData['end_date'] = $end_date->toDateString();     // กลับเป็น string วันที่
        
                            // dd($saveData, $data);
                            break;
                    }
                    return $saveData;
                    // dd($start_date);
                }),
        ];
    }
}
