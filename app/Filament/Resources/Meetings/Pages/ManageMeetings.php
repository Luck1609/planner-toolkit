<?php

namespace App\Filament\Resources\Meetings\Pages;

use App\Enums\MeetingTypeEnum;
use App\Filament\Resources\Meetings\MeetingResource;
use App\Models\Committee;
use App\Models\Meeting;
use App\Services\FormService;
use App\Services\MeetingService;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Illuminate\Support\Arr;

class ManageMeetings extends ManageRecords
{
  protected static string $resource = MeetingResource::class;

  protected function getHeaderActions(): array
  {
    return [
      CreateAction::make()
        ->modal()
        ->steps(MeetingService::meetingForm())
        ->mountUsing(fn (Schema $form) => $form->fill(MeetingService::formFiller(MeetingTypeEnum::CUSTOM)))
        ->action(fn (array $data) => MeetingService::saveRecord($data))
        ->modalWidth(Width::TwoExtraLarge),
    ];
  }
}
