<?php

namespace App\Filament\Resources\Applications\Pages;

use App\DTO\ActiveSessionDTO;
use App\Filament\Resources\Applications\ApplicationResource;
use App\Models\Application;
use App\Models\MonthlySession;
use App\Models\Office;
use App\Models\Sector;
use App\Services\FormService;
use App\Services\HelperService;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Components\Group;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ManageApplications extends ManageRecords
{
  protected static string $resource = ApplicationResource::class;

  protected function getHeaderActions(): array
  {
    $sessionDto = (new ActiveSessionDTO())();

    Log::info('Session DTO', ['exist' => $sessionDto->exists, 'session' => $sessionDto->session]);
    return [
      ...!$sessionDto->exists
        ? $this->getCreateSessionAction()
        : $this->getCreateApplicationAction()
    ];
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


  protected function getCreateSessionAction(): array
  {
    return [
      Action::make('New session')
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
          $currentSession = MonthlySession::create([
            ...$data,
            'is_current' => true,
            'finalized' => false
          ]);

          $this->dispatch('refresh');

          return $currentSession;
        })
        ->successNotification(
          Notification::make()
            ->success()
            ->title('Session Created')
            ->body('The session has been successfully created')
        ),
    ];
  }

  protected function getCreateApplicationAction(): array
  {
    return [
      CreateAction::make()
        ->steps(FormService::applicationForm())
        ->mutateDataUsing(function (array $data) {
          return [
            ...$data,
            'user_id' => Auth::user()->id,
            ...$this->generateApplicationNumber($data)
          ];
        })
        ->using(fn(array $data, string $model): Model => $model::create($data))
        ->successNotification(
          Notification::make()
            ->success()
            ->title('Application Created')
            ->body('The application has been successfully created')
        )
    ];
  }

  protected function generatePermitNumbers(): array
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

  protected function generateApplicationNumber(array $data): array
  {
    $date = Carbon::parse(now());

    $officeInitials = Office::first()->initials;
    $sector = Sector::with('locality')->find($data['sector_id']);
    $localityInitials = $sector->locality->initials;
    $sectorInitials = $sector->initials;
    $session = MonthlySession::whereYear('created_at', $date->year)->count();
    $sessionCount = $session > 9 ? $session : "0{$session}";

    $year = Str::substr($date->year, 2, 2);

    $applicationNumber =  $data['application_number'] ?? "{$officeInitials}/{$sectorInitials}/{$localityInitials}/{$sessionCount}/{$year}";

    return [
      'application_num' => $applicationNumber,
      'session_num' => $sessionCount,
      'monthly_session_id' => MonthlySession::where('is_current', true)->first()->id,
    ];
  }
}
