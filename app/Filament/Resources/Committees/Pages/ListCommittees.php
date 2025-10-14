<?php

namespace App\Filament\Resources\Committees\Pages;

use App\Filament\Resources\Committees\CommitteeResource;
use App\Models\Committee;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Grid;
use Illuminate\Database\Eloquent\Model;

use function Livewire\Volt\placeholder;

class ListCommittees extends ListRecords
{
  protected static string $resource = CommitteeResource::class;

  protected function getHeaderActions(): array
  {
    return [
      CreateAction::make()
        ->schema([
          Grid::make(2)
            ->schema([
              Grid::make(5)
                ->schema([
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
                  TextInput::make('firstname')->required()->placeholder('Type in member\s firstname')->columnSpan(2),
                  TextInput::make('lastname')->required()->placeholder('Type in member\s lastname')->columnSpan(2),
                ])->columnSpanFull(),

              Grid::make(4)
                ->schema([
                  Select::make('panel')
                    ->options([
                      'SPC' => 'SPC',
                      'TSC' => 'TSC',
                    ])
                    ->required(),
                  Select::make('role')
                    ->options([
                      'Chairperson' => 'Chairperson',
                      'Secretary' => 'Secretary',
                      'Member' => 'Member',
                      'Other' => 'Other',
                    ])
                    ->required(),
                  TextInput::make('designation')
                    ->required()
                    ->placeholder('Type in member\s designation')
                    ->columnSpan(2),
                ])->columnSpanFull(),

              TextInput::make('email')->required()->email()->placeholder('Type in member\s email address'),
              TextInput::make('contact')->label('Phone number')->required()->placeholder('Type in member\s phone number'),
            ])
        ])
        ->using(function (array $data): Model {
          return Committee::create([
            'title' => $data['title'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'panel' => $data['panel'],
            'contact' => $data['contact'],
            'role' => $data['role'],
            'email' => $data['email'],
            'designation' => $data['designation'],
          ]);
        }),
    ];
  }
}
