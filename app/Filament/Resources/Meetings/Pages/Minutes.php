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

  public function mount(int|string $record): void
  {
    // logger('', ['minute-record' => $record]);
    // $meeting = $this->resolveRecord($record);
    $minute = Minute::find($record);
    $this->record = $minute;
    // logger('', ['mount-record' => $this->record]);

    // $this->form->fill([
    //   'title' => $minute->meeting->title ?: '',
    //   'venue' => $minute->meeting->venue ?: '',
    //   'date' => $minute->meeting->date ?: '',
    //   'time' => $minute->meeting->time ?: '',
    //   // 'participants' => $meeting->participants ?: [],
    //   // 'content' => $this->record->content ?: [],
    //   // 'recorded_by' => [
    //   //   'name' => data_get($this->record->recorded_by, 'name'),
    //   //   'role' => data_get($this->record->recorded_by, 'role'),
    //   //   'designation' => data_get($this->record->recorded_by, 'designation'),
    //   // ],
    //   // 'approved_by' => [
    //   //   'name' => data_get($this->record->approved_by, 'name'),
    //   //   'role' => data_get($this->record->approved_by, 'role'),
    //   //   'designation' => data_get($this->record->approved_by, 'designation'),
    //   // ]
    // ]);
  }

  protected function mutateFormDataBeforeFill(array $data): array
  {
    logger('', ['mutation' => $data]);
    return $data;
  }

  public function form(Schema $form): Schema
  {
    return $form
      // ->mount(function ($record) {
      //   logger('', ['mounted-data' => $record]);
      // })
      ->schema([
        Wizard::make([
          Step::make('Meeting Information')
            ->schema([
              Group::make()
                ->schema([
                  TextInput::make('title')
                    ->formatStateUsing(function ($record) {
              logger('', ['mounted-data' => $record]);
            })
                    ->placeholder('Title')
                    ->nullable()
                    ->columnSpan(2),
                  Group::make([
                    TextInput::make('venue')
                      ->placeholder('Venue')
                      ->nullable(),
                    DatePicker::make('date')
                      ->date()
                      ->nullable()
                      ->beforeOrEqual(now())
                      ->validationMessages([
                        'beforeOrEqual' => ':attribute can\'t be in the future'
                      ])
                      ->validationAttribute('Minute date'),
                    TimePicker::make('time')
                      ->time(),
                  ])
                    ->columns(3)
                    ->columnSpanFull(),

                  Section::make('Meeting Participants')
                    ->description('List of all members of this meeting')
                    ->schema([
                      Repeater::make('participants')
                        ->schema([
                          TextInput::make('name')->placeholder('Full name'),
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
                          ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                          ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                          ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                          ['table', 'attachFiles'], // The `customBlocks` and `mergeTags` tools are also added here if those features are used.
                          ['undo', 'redo'],
                        ])
                        // ->toolbarButtons([
                        //   'bold',
                        //   'bulletList',
                        //   'heading',
                        //   'table',
                        //   'italic',
                        //   'link',
                        //   'orderedList',
                        //   'redo',
                        //   'strike',
                        //   'underline',
                        //   'undo',
                        // ])
                        ->disableToolbarButtons([
                          'attachFiles',
                          'blockquote',
                          'codeBlock',
                        ])
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
