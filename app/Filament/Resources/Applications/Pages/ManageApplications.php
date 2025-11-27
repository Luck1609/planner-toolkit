<?php

namespace App\Filament\Resources\Applications\Pages;

use App\ActiveSessionTrait;
use App\DTO\ActiveSessionDTO;
use App\Filament\Resources\Applications\ApplicationResource;
use App\Models\Application;
use App\Models\MonthlySession;
use App\Models\Office;
use App\Models\Sector;
use App\Services\ApplicationService;
use App\Services\FormService;
use App\Services\HelperService;
use App\SessionService;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Components\Group;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ManageApplications extends ManageRecords
{
  use ActiveSessionTrait;

  protected static string $resource = ApplicationResource::class;

  protected function getHeaderActions(): array
  {
    if (!$this->sessionExists())
      return $this->sessionAction();

    return $this->createAction();
  }



  private function checkDuplicates(array $data): array
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


  protected function sessionAction(): array
  {
    return [
      Action::make('New session')
        ->icon('icon-calendar-plus')
        ->schema([
          Group::make([
            TextInput::make('title')->required()->columnSpanFull(),
            DatePicker::make('start_date')->required()->columns(1),
            DatePicker::make('end_date')->required()->after('start_date')->columns(1),
          ])
            ->columns(2)
        ])
        ->modalWidth(Width::ExtraLarge)
        ->action(function (array $data) {
          MonthlySession::create([
            ...$data,
            'is_current' => true,
            'finalized' => false
          ]);

          return redirect('/applications');
        })
        ->successNotification(
          Notification::make()
            ->success()
            ->title('Session Created')
            ->body('The session has been successfully created')
        ),
    ];
  }

  public function createAction(): array
  {
    return [
      Action::make('create')
        ->label('New application')
        ->icon(Heroicon::OutlinedPlus)
        ->steps(ApplicationService::form())

        ->mutateDataUsing(fn (array $data) => [
            ...$data,
            'user_id' => Auth::user()->id,
            ...ApplicationService::generateApplicationNumber($data)
          ])
        ->action(function (array $data): Model {
          $coordinates = Arr::pull($data, 'coordinates');

          data_set(
            $data,
            'height',
            $data['type'] === 'single' ? 1 : $data['height']
          );

          logger('create-application', ['data' => $data]);

          $application = Application::create($data);

          $firstLongitude = data_get($coordinates, '0.longitude');
          $firstLatitude = data_get($coordinates, '0.latitude');

          if ($firstLongitude && $firstLatitude)
            $application->coordinates()->createMany($coordinates);

          return $application;
        })
        ->successNotification(
          Notification::make()
            ->success()
            ->title('Application Created')
            ->body('The application has been successfully created')
        ),
      SessionService::sessionEndButton($this->session),
      ...$this->sessionIsFinalized()
        ? [
          Action::make('Download records')
            ->icon(Heroicon::OutlinedArrowDownTray),
        ]
        : []
    ];
  }
}
