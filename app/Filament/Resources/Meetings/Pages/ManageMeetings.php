<?php

namespace App\Filament\Resources\Meetings\Pages;

use App\Enums\MeetingTypeEnum;
use App\Filament\Resources\Meetings\MeetingResource;
use App\Models\Committee;
use App\Models\Meeting;
use App\Services\FormService;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;

class ManageMeetings extends ManageRecords
{
  protected static string $resource = MeetingResource::class;

  protected function getHeaderActions(): array
  {
    $isCustom = true;

    return [
      CreateAction::make()
        ->modal()
        ->steps(FormService::meetingForm($isCustom))
        ->mountUsing(fn (Schema $form) => [
          $form->fill([
            'title' => '',
            'type' => MeetingTypeEnum::CUSTOM,
            'agenda' => '',
            'venue' => '',
            'date' => '',
            'time' => '',
            // 'participants' => [],
            // 'new_participants' => []
          ])
        ])
        ->using(function (array $data) {
          logger('', ['create-data' => $data]);
          $participants = Committee::whereIn($data['participants'])->get();
          $participants = $participants->map(fn ($participant) => [
            'participant_id' => $participant->id,
            'title' => $participant->title,
            'firstname' => $participant->firstname,
            'lastname' => $participant->lastname,
            'contact' => $participant->contact,
            'designation' => $participant->designation,
            'role' => $participant->role,
          ]);

          $participants = array_merge($participants, $data['new_participants']);
          unset($data['new_participants'], $data['participants']);

          $meeting = Meeting::create($data);

          $meeting->participants()->createMany($participants);
        })
        ->action(function (array $data) {
          logger('', ['meeting-data' => $data]);
        })
        ->modalWidth(Width::TwoExtraLarge)
        ->skippableSteps(),
    ];
  }
}
