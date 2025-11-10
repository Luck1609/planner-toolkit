<?php

namespace App\Filament\Resources\Applications\Pages;

use App\Filament\Resources\Applications\ApplicationResource;
use App\Models\Application;
use App\Models\MonthlySession;
use App\Models\Office;
use App\Models\Sector;
use App\Services\FormService;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Components\Group;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ManageApplications extends ManageRecords
{
  protected static string $resource = ApplicationResource::class;
  private static array $coordinates = [];
  private MonthlySession | null $session;

  protected function getHeaderActions(): array
  {
    $this->session = MonthlySession::where('is_current', true)->where('finalized', false)->first();

    logger('', ['session' => $this->session]);

    return [
      ...!isset($this->session)
        ? [
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

              $this->session = $currentSession;
              return $currentSession;
            }),
        ]
        : [
          CreateAction::make()
            ->steps(FormService::applicationForm())
            ->mutateDataUsing(function (array $data) {

              return [
                ...$data,
                'user_id' => Auth::user()->id,
                ...$this->generateApplicationNumber($data)
              ];
            })
            ->using(function (array $data, string $model): Model {
              logger('', ['application-details' => $data]);
              $application = Application::create([
                "title" => $data['title'],
                "firstname" => $data['firstname'],
                "lastname" => $data['lastname'],
                "contact" => $data['contact'],
                "house_no" => $data['house_no'],
                "address" => $data['address'],
                "locality_id" => $data['locality_id'],
                "sector_id" => $data['sector_id'],
                "block" => $data['block'],
                "plot_number" => $data['plot_number'],
                "type" => $data['type'],
                "existing" => $data['existing'],
                "use" => $data['use'],
                "application_num" => $data['application_num'],
                "shelf" => $data['shelf'],
              ]);
            })
        ]
    ];
  }

  private function checkDuplicates(array $data): array
  {
    $status = [];

    $duplicate = Application::where('locality_id', $data['locality_id'])
      ->where('sector_id', $data['sector_id'])
      ->where('block', $data['block'])->get();

    foreach ($duplicate as $application) {
      $found = Str::position($application->plot_number, $data['plot_number']);

      if (gettype($found) === 'integer') {
        $status[] = $application;
      }
    }

    return $status;
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
