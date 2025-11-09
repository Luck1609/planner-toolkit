<?php

namespace App\Services;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;

use function Livewire\Volt\placeholder;

class FormService
{
  public static function meetingForm(?bool $modalForm = false): array
  {
    return [
      Wizard::make([
        Step::make('Meeting Information')
          ->schema([
            TextInput::make('title')
              ->placeholder('Title for this meeting')
              ->required()
              ->columnSpan(['lg' => 2]),
            Select::make('type')
              ->placeholder('Select meeting type')
              ->options([
                'spc' => 'SPC',
                'tsc' => 'TSC',
                'custom' => 'Custom'
              ]),
            TextInput::make('agenda')
              ->placeholder('Agenda for this meeting')
              ->columnSpan(['lg' => 2]),
            TextInput::make('venue')->required(),
            Hidden::make('monthly_session_id'),
            DatePicker::make('date')->required(),
            TimePicker::make('time')->required()
          ])->columns(['lg' => 3]),

        Step::make('Participants Information')
          ->schema([
            Repeater::make('participants')
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
                  TextInput::make('firstname')->required()->placeholder('Type in member\s firstname')
                    ->columnSpan(['lg' => 2]),
                ])->columns(['lg' => 3]),
                Group::make([
                  TextInput::make('lastname')->required()->placeholder('Type in member\s lastname'),
                  TextInput::make('contact')->label('Phone number')->required()->placeholder('024XXXXXXX'),
                ])->columns(['lg' => $modalForm ? 1 : 2]),
              ])
              ->required()
              ->minItems(2)
              ->grid(2)
              ->columnSpanFull()
              ->addActionLabel('Add participant')
          ])
          ->columns(['lg' => 3])
          ->columnSpanFull(),
      ])->columnSpanFull()
    ];
  }
}
