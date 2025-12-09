<?php

namespace App\Filament\Resources\Meetings\Pages;

use App\Filament\Resources\Meetings\MeetingResource;
use App\Models\Minute;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

class Minutes extends Page
{
  use InteractsWithRecord;

  protected static string $resource = MeetingResource::class;

  protected string $view = 'filament.resources.meetings.pages.minutes';

  public ?array $formData = [];

  public function mount(int|string $record): void
  {
    $this->record = $this->resolveRecord($record);

    $this->formData = [
      'title' => $this->record->title,
      'venue' => $this->record->venue,
      'date' => $this->record->date,
      'time' => $this->record->time,
      'participants' => $this->record->participants?->map(fn ($participant) => [
        'name' => "$participant->firstname $participant->lastname",
        'role' => $participant->role,
        'designation' => $participant->designation
      ]),
      'content' => $this->record->minute->content ?: [],
      'recorded_by' => [
        'name' => data_get($this->record->minute->recorded_by, 'name'),
        'role' => data_get($this->record->minute->recorded_by, 'role'),
        'designation' => data_get($this->record->minute->recorded_by, 'designation'),
      ],
      'approved_by' => [
        'name' => data_get($this->record->minute->approved_by, 'name'),
        'role' => data_get($this->record->minute->approved_by, 'designation'),
      ]
    ];
  }


  public function form(Schema $form): Schema
  {
    return $form
      ->schema([
        Wizard::make([
          Step::make('Meeting Information')
            ->schema([
              Group::make()
                ->schema([
                  TextInput::make('title')
                    ->statePath('formData.title')
                    ->placeholder('Title')
                    ->nullable()
                    ->columnSpan(2),
                  Group::make([
                    TextInput::make('venue')
                    ->statePath('formData.venue')
                      ->placeholder('Venue')
                      ->nullable(),
                    DatePicker::make('date')
                    ->statePath('formData.date')
                      ->date()
                      ->nullable(),
                    TimePicker::make('time')
                    ->statePath('formData.time')
                      ->time(),
                  ])
                    ->columns(3)
                    ->columnSpanFull(),

                  Section::make('Meeting Participants')
                    ->description('List of all members of this meeting')
                    ->schema([
                      Repeater::make('participants')
                        ->statePath('formData.participants')
                        ->schema([
                          TextInput::make('name')
                            ->formatStateUsing(function ($state) {
                              logger('', ['state' => $state]);
                            })
                            ->placeholder('Full name'),
                          TextInput::make('role')->placeholder('Secretary'),
                          TextInput::make('designation')->placeholder('Physical Planning Department')
                        ])
                        ->itemLabel('Participant information')
                        ->addActionLabel('Add Members Present')
                        ->grid(2)
                        ->columnSpanFull(),

                      Repeater::make('absentees')
                        ->label('Absented Members (Members)')
                        ->schema([
                          TextInput::make('name')->placeholder('Full name'),
                          TextInput::make('role')->placeholder('Secretary'),
                          TextInput::make('designation')->placeholder('Physical Planning Department')
                        ])
                        ->itemLabel('Participant information')
                        ->addActionLabel('Add Members Absent')
                        ->grid(2)
                        ->columnSpanFull(),

                      Repeater::make('attendees')
                        ->label('In Attendance (Non-members)')
                        ->schema([
                          TextInput::make('name')->placeholder('Full name'),
                          TextInput::make('designation')->placeholder('Physical Planning Department')
                        ])
                        ->itemLabel('Participant information')
                        ->addActionLabel('Add Meeting Attendee')
                        ->grid(2)
                        ->columnSpanFull()
                    ])
                    ->columnSpanFull()
                ]),

            ]),
          Step::make('Minute Contents')
            ->schema([
              Section::make('Main Contents')
                ->description('Here is the main contents of the minutes')
                ->schema([
                  Repeater::make('content')->label('')
                    ->schema([
                      TextInput::make('title'),
                      RichEditor::make('contents')
                        ->label('Create Minutes')
                        ->columnSpanFull()
                        ->toolbarButtons([
                          ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                          ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                          ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                          ['table', 'attachFiles'], // The `customBlocks` and `mergeTags` tools are also added here if those features are used.
                          ['undo', 'redo'],
                        ])
                        // ->disableToolbarButtons([
                        //   'attachFiles',
                        //   'blockquote',
                        //   'codeBlock',
                        // ])
                        ->columnSpanFull(),
                    ])
                    ->grid(2)
                    ->itemLabel(fn(array $state): ?string => $state['label'] ?? '')
                    ->defaultItems(7)
                    ->addActionLabel('Add section')
                    ->collapsible()
                    ->columnSpanFull()
                ])
            ]),

          Step::make('Author & Approver')
            ->schema([
              Group::make([
                Repeater::make('recorded_by')
                  ->schema([
                    TextInput::make('name')->placeholder('Full name'),
                    TextInput::make('role')->placeholder('Secretary'),
                    TextInput::make('designation')->placeholder('Physical Planning Department')
                  ])
                  ->addable(false),

                Repeater::make('approved_by')
                  ->schema([
                    TextInput::make('name')->placeholder('Full name'),
                    TextInput::make('role')->placeholder('Chairperson'),
                    TextInput::make('designation')->placeholder('Physical Planning Department')
                  ])
                  ->addable(false)
              ])
                ->columns(2)
                ->columnSpanFull()
            ])


        ])
          ->columnSpanFull(),
      ]);
  }
}
