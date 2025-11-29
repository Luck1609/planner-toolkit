<?php

namespace App\Services;

use App\Models\Application;
use App\Models\Locality;
use App\Models\MonthlySession;
use App\Models\Office;
use App\Models\Sector;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class ApplicationService
{
  public static function form(): array
  {
    return [
      Step::make('Applicant\'s Information')
        ->schema([
          Group::make([
            Select::make('title')
              ->placeholder('Select title')
              ->options(HelperService::getTitles())
              ->searchable()
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
            // ->relationship('coordinates')
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
              // ->columns(3)
              ->maxWidth('50%'),

            Radio::make('existing')
              ->options([1 => 'Existing', 0 => 'New'])
              ->label('Property development state'),
            // ->columns(3),

            TextInput::make('height')
              ->integer()
              ->placeholder('Height of building')
              ->visibleJs(<<<'JS'
                $get('type') === 'multi'
              JS),
          ])->columns(3),
          Group::make([
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
              ->columns(['lg' => 2])
              ->columnSpan(['lg' => 2]),
          ])
            ->columns(['lg' => 3])

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
            ->acceptedFileTypes(['image/jpg', 'image/jpeg', 'image/png', 'image/webp', 'application/pdf'])
        ])->columns(2)
    ];
  }

  public static function generateApplicationNumber(array $data): array
  {
    $date = Carbon::parse(now());

    $officeInitials = Office::first()->initials;
    $sector = Sector::with('locality')->find($data['sector_id']);
    $localityInitials = $sector->locality->initials;
    $sectorInitials = $sector->initials;
    $session = MonthlySession::whereYear('created_at', $date->year)->count();
    $sessionCount = $session > 9 ? $session : "0{$session}";

    $year = Str::substr($date->year, 2, 2);

    $applicationNumber =  data_get(
      $data,
      'application_number',
      "{$officeInitials}/{$sectorInitials}/{$localityInitials}/{$sessionCount}/{$year}"
    );

    return [
      'application_num' => $applicationNumber,
      'session_num' => $sessionCount,
      'monthly_session_id' => MonthlySession::where('is_current', true)->first()->id,
    ];
  }


  public static function generatePermitNumbers(): array
  {
    $session = MonthlySession::with('applications')->where('status', true)->first();
    $count = 0;

    $initials = Office::first()->initials;

    // foreach ($session->applications as $application) {
    //   $count++;
    //   $permit_num = $initials . '/DEV/PER/' . ($count < 10 ? '0' . $count : $count) . '/0' . str_split($event->quarter->quarter_name)[0] . '/' . Carbon::parse($app->created_at)->isoFormat('YY');
    //   $dev_permit_num = $initials . '/BP/' . ($count < 10 ? '0' . $count : $count) . '/0' . str_split($event->quarter->quarter_name)[0] . '/' . Carbon::parse($app->created_at)->isoFormat('YY');

    //   $application->update([
    //     'pemit_num' => $permit_num,
    //     'dev_pemit_num' => $dev_permit_num,
    //   ]);
    // }

    return [];
  }


  public static function checkDuplicates(array $data): array
  {
    $matches = Application::where('locality_id', $data['locality_id'])
      ->where('sector_id', $data['sector_id'])
      ->where('block', $data['block'])->get();

    return $matches->reduce(function ($duplicates, $application) use ($data) {
      $found = Str::position($application->plot_number, $data['plot_number']);

      return gettype($found) === 'integer'
        ? [...$duplicates, $application]
        : $duplicates;
    }, []);
  }

  public static function showConfirmation(array $status, MonthlySession $session): Action
  {
    $action = self::getBulkActionButton(
      status: $status,
      session: $session,
    );

    return data_get($status, 'requires_comment', false)
      ? $action
      ->modal()
      ->steps(
        fn(Collection $records) => ($records->chunk(2))->map(
          fn($batch, $batchIndex) => Step::make(Number::ordinal($batchIndex + 1) . ' Batch of Applications')
            ->schema(
              $batch->map(
                fn($record) => Section::make("Comments for {$record->title} {$record->firstname} {$record->lastname}")
                  ->description('Type in the comments received for this application')
                  ->schema([
                    RichEditor::make("applications.{$record->id}.comments")
                      ->label('Reason for the action')
                      ->required(),
                  ])
              )->toArray()
            )
        )->toArray()
      )
      ->action(
        fn(array $data, Action $action) => collect(data_get($data, 'applications'))->each(
          function ($field, $key) use ($session, $status, $action) {
            try {
            $application = Application::find($key);

            logger('', ['key' => $key, 'comments' => data_get($field, 'comments')]);

            $application
              ->sessions()
              ->attach($application->id, [
                'status' => $status['state'],
                'monthly_session_id' => $session->id,
                'comments' => data_get($field, 'comments'),
              ]);
            } catch (\Throwable $th) {
              $action->reportBulkProcessingFailure(
                'status_update_failed',
                message: $th->getMessage()
              );
            }
          }
        )
      )
      : $action
      ->requiresConfirmation()
      ->modalHeading(fn(Collection $records) => $status['name'] . ($records->count() > 1 ? ' Applications' : ' Application'))
      ->modalDescription(
        fn(Collection $records) => $records->count() . ' ' . (
          $records->count() > 1
          ? 'applications'
          : 'application'
        )
          . ' has been selected to be ' . $status['state'] . ', do you wish to continue with this action?'
      );
  }

  private static function getBulkActionButton(array $status, MonthlySession $session): Action
  {
    $color = $status['color'];

    return BulkAction::make($status['name'])
      ->button()
      ->outlined()
      ->color($color)
      ->icon(Heroicon::OutlinedCheckBadge)
      ->extraAttributes([
        'class' => "text-{$color}-600 dark:text-{$color}-500",
      ])
      ->successNotification(
        fn(Collection $records) => Notification::make()
          ->title('Application Status Updated')
          ->body("{$records->count()} applications have been successfully {$status['state']}")
          ->color('success')
          ->success()
          ->send()
      )
      ->failureNotification(
        fn(Collection $records) => Notification::make()
          ->title('Application Status Updated')
          ->body("{$records->count()} applications have been successfully {$status['state']}")
          ->color('success')
          ->success()
          ->send()
      )
      ->deselectRecordsAfterCompletion();
  }
}
