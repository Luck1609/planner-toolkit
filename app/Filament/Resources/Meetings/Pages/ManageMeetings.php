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
use Illuminate\Support\Arr;

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
          ])
        ])
        ->action(function (array $data) {
          $participantIds = collect(Arr::pull($data, 'participants', []))->pluck('participant_id');

          $participants = Committee::whereIn('id', $participantIds)->get();

          $participants = $participants->map(fn ($participant) => [
            'committee_id' => $participant->id,
            'title' => $participant->title,
            'firstname' => $participant->firstname,
            'lastname' => $participant->lastname,
            'phone_number' => $participant->contact,
            'designation' => $participant->designation,
            'role' => $participant->role,
          ])->toArray();

          $participants = array_merge($participants, Arr::pull($data, 'new_participants', []));

          $meeting = Meeting::create($data);

          $meeting->participants()->createMany($participants);
          return $meeting;
        })
        ->modalWidth(Width::TwoExtraLarge)
        ->skippableSteps(),
    ];
  }
}
