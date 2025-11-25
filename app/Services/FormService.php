<?php

namespace App\Services;

use App\Models\Committee;
use App\Models\Locality;
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

class FormService
{
  public static function meetingForm(?bool $isCustom = false): array
  {
    return [
      Step::make('Meeting Information')
        ->schema([
          TextInput::make('title')
            ->placeholder('Title for this meeting')
            ->required()
            ->columnSpan(['lg' => !$isCustom ? 2 : 3]),
          ...!$isCustom
            ? [
              Select::make('type')
                ->placeholder('Select meeting type')
                ->options([
                  'spc' => 'SPC',
                  'tsc' => 'TSC',
                  'custom' => 'Custom'
                ]),
            ]
            : [Hidden::make('type')],
          TextInput::make('agenda')
            ->placeholder('Agenda for this meeting')
            ->columnSpan(['lg' => !$isCustom ? 2 : 3]),
          Group::make([
            TextInput::make('venue')
              ->placeholder('Meeting venue')
              ->columnSpan(3)
              ->required(),
            Hidden::make('monthly_session_id'),
            DatePicker::make('date')
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
                ->options(Committee::all()->select('firstname', 'lastname', 'id', 'title')->reduce(
                  fn($members, $member) => [
                    ...$members,
                    $member['id'] => $member['title'] . ' ' . $member['firstname'] . ' ' . $member['lastname']
                  ],
                  []
                )),
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

  public static function applicationForm(): array
  {
    return [
      Step::make('Applicant\'s Information')
        ->schema([
          Group::make([
            Select::make('title')
              ->placeholder('Select title')
              ->options([
                'Mr' => 'Mr',
                'Mrs' => 'Mrs',
                'Miss' => 'Miss',
                'Dr' => 'Dr',
                'Prof' => 'Prof',
                'Eng' => 'Eng',
                'Pln' => 'Pln',
                'Esq' => 'Esq',
              ])
              ->required(),
            TextInput::make('firstname')
              ->columnSpan(2)
              ->required()
              ->placeholder('Firstname'),
            TextInput::make('lastname')
              ->columnSpan(2)
              ->required()
              ->placeholder('Lastname'),
            TextInput::make('contact')
              ->required()
              ->placeholder('Phone number'),
            TextInput::make('house_no')
              ->columnSpan(2)
              ->required()
              ->placeholder('House number'),
            TextInput::make('address')
              ->columnSpan(2)
              ->required()
              ->placeholder('Address')
          ])->columns(5)
        ]),

      Step::make('Plot Information')
        ->schema([
          Group::make([
            Select::make('locality_id')
              ->options(Locality::all()->pluck('name', 'id'))
              ->required()
              ->live(),

            Select::make('sector_id')
              ->options(fn(Get $get) => Sector::where('locality_id', $get('locality_id'))->get()->pluck('name', 'id'))
              ->required()
              ->live(),

            Select::make('block')
              ->options(fn(Get $get): array => Sector::find($get('sector_id'))?->blocks ?: [])
              ->required(),
            TextInput::make('plot_number')->required()->placeholder('Type in plot no.')->live(),
          ])->columns(4),

          Repeater::make('coordinates')
            ->label('Coordinates Information')
            ->relationship('coordinates')
            ->schema([
              TextInput::make('longitude')
                ->placeholder('Longitude')
                ->label('Longitude')
                ->regex('/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'),
              TextInput::make('latitude')
                ->placeholder('Latitude')
                ->regex('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/')
                ->label('Latitude')
            ])
            ->addActionLabel('Add New Coordinates')
            ->grid(3)
            ->itemLabel('Coordinates')
        ]),


      Step::make('Building Information')
        ->schema([
          Group::make([
            Radio::make('type')
              ->options([
                'single' => 'Single storey',
                'multi' => 'Multi storey',
              ])
              ->label('Height of building')
              ->live()
              ->columns(3)
              ->maxWidth('50%'),

            Radio::make('existing')
              ->options([1 => 'Existing', 0 => 'New'])
              ->label('Property development state')
              ->columns(3),

            TextInput::make('height')
              ->integer()
              ->placeholder('Height of building')
              ->visible(fn(Get $get) => $get('type') === 'multi'),
          ])->columns(2),

          CheckboxList::make('use')
            ->options([
              'residential' => 'Residential',
              'commercial' => 'Commercial',
              'civic_&_culture' => 'Civic & Culture',
              'Education' => 'Education',
              'industrial' => 'Industrial',
              'open space' => 'Open Space',
              'sanitation' => 'Sanitation',
            ])
            ->label('Land use')
            ->columns(3),
        ])
        ->columnSpan(1),

      Step::make('Other Information')
        ->schema([
          TextInput::make('application_num')
            ->placeholder('SMA/SEC 1/AR1/01/25')
            ->label('Application number'),
          TextInput::make('shelf')
            ->placeholder('Shelf no.')
            ->label('Shelf number'),


          SpatieMediaLibraryFileUpload::make('attachements')
            ->label('Add required documents (EPA permit, Fire permit ...)')
            ->multiple()
            ->columnSpanFull()
            ->acceptedFileTypes(['image/jpg', 'image/jpeg', 'image/png', 'image/webp', 'appliction/pdf'])
        ])->columns(2)
    ];
  }
}
