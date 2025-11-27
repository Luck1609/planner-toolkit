<?php

namespace App\Services;


use App\Enums\MeetingTypeEnum;
use App\Models\Committee;
use App\Models\Locality;
use App\Models\Meeting;
use App\Models\Sector;
use App\Models\Setting;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Wizard\Step;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class MeetingService
{
  public static function meetingForm(): array
  {
    return [
      Step::make('Meeting Information')
        ->schema([
          TextInput::make('title')
            ->placeholder('Title for this meeting')
            ->required()
            ->columnSpan(['lg' => 3]),
          Hidden::make('monthly_session_id'),
          Hidden::make('type'),
          TextInput::make('agenda')
            ->placeholder('Agenda for this meeting')
            ->columnSpan(['lg' => 3]),
          Group::make([
            TextInput::make('venue')
              ->placeholder('Meeting venue')
              ->columnSpan(3)
              ->required(),
            Hidden::make('monthly_session_id'),
            DatePicker::make('date')
              ->afterOrEqual('today')
              ->columnSpan(2)
              ->required(),
            TimePicker::make('time')
              ->columnSpan(2)
              ->required()
          ])
            ->columns(7)
            ->columnSpanFull()
        ])->columns(['lg' => 3]),

      Step::make('Committee Members')
        ->schema([
          Repeater::make('participants')
            ->schema([
              Select::make('participant_id')
                ->label('')
                ->searchable()
                ->options(fn(Get $get) => Committee::select('firstname', 'lastname', 'id', 'title')
                  ->when(
                    ($get('type') === MeetingTypeEnum::TSC->value || $get('type') === MeetingTypeEnum::SPC->value),
                    fn($query) => $query->where('panel', $get('type'))
                  )
                  ->get()
                  ->reduce(
                    fn($members, $member) => [
                      ...$members,
                      $member['id'] => $member['title'] . ' ' . $member['firstname'] . ' ' . $member['lastname']
                    ],
                    []
                  )),
              // ->options(fn (Get $get) => Committee::select('firstname', 'lastname', 'id', 'title')
              //   ->when(
              //     ($get('type') === MeetingTypeEnum::TSC->value || $get('type') === MeetingTypeEnum::SPC->value),
              //     fn ($query) => $query->where('panel', $get('type'))
              //   )
              //   ->get()
              //   ->reduce(
              //   fn($members, $member) => [
              //     ...$members,
              //     $member['id'] => $member['title'] . ' ' . $member['firstname'] . ' ' . $member['lastname']
              //   ],
              //   []
              // )),
            ])
            ->required()
            ->minItems(2)
            ->grid(2)
            ->columnSpanFull()
            ->addActionLabel('Add participant'),
        ])
        ->columns(['lg' => 3])
        ->columnSpanFull(),
      Step::make('New Participants')
        ->schema([
          Repeater::make('new_participants')
            ->schema([
              Group::make(
                [
                  Select::make('title')
                    ->options(HelperService::getTitles())
                    ->placeholder('Select role')
                    ->required(),
                  TextInput::make('firstname')
                    ->required()
                    ->placeholder('Member\'s firstname'),
                  TextInput::make('lastname')
                    ->required()
                    ->placeholder('Member\'s lastname'),
                  TextInput::make('designation')
                    ->nullable()
                    ->placeholder('Designation'),
                  Select::make('role')
                    ->options(HelperService::getCommitteeRoles())
                    ->placeholder('Select role')
                    ->required(),
                  TextInput::make('phone_number')
                    ->label('Phone number')
                    ->required()
                    ->placeholder('024XXXXXXX'),
                ]
              )
                ->columns(2),
            ])
            ->grid(2)
            ->columnSpanFull()
            ->addActionLabel('Add participant')
        ])
    ];
  }

  public static function formFiller(MeetingTypeEnum $type, ?Model $record = null, ?array $defaults = [])
  {
    return [
      'title' => $record?->title ?: '',
      'monthly_session_id' => $record?->monthly_session_id ?: '',
      'type' => $type,
      'agenda' => $record?->agenda ?: '',
      'date' => $record?->date ?: '',
      'time' => $record?->time ?: '',
      'venue' => $record?->venue ?: '',
      'participants' => $record?->participants ?: [],
      ...$defaults
    ];
  }

  public static function saveRecord(array $data) //: Model
  {
    $participantIds = array_unique(
      collect(Arr::pull($data, 'participants', []))
        ->pluck('participant_id')
        ->toArray()
    );
    $participants = Committee::whereIn('id', collect($participantIds))->get();

    $participants = $participants->map(fn($participant) => [
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
  }
}
