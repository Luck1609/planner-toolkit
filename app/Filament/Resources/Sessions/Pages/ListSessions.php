<?php

namespace App\Filament\Resources\Sessions\Pages;

use App\DTO\ActiveSessionDTO;
use App\DTO\MeetingTypeDTO;
use App\Filament\Resources\Sessions\SessionResource;
use App\MeetingTypeEnum;
use App\Models\MonthlySession;
use App\Services\FormService;
use App\Services\HelperService;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Arr;

class ListSessions extends ListRecords
{
  protected static string $resource = SessionResource::class;

  protected function getHeaderActions(): array
  {
    $activeSession = (new ActiveSessionDTO())();
    return [
      !$activeSession->exists || !$activeSession->active
        ? CreateAction::make()
        : $this->sessionEndButton($activeSession),
    ];
  }

  private function sessionEndButton(ActiveSessionDTO $activeSession): Action
  {
    $session = $activeSession->session;

    return $session->finalized
      // ? Action::make('End session')
      ? $this->meetingButtons($activeSession)
      : Action::make('Finalize session')
      ->color(Color::Amber)
      ->icon(Heroicon::OutlinedLockClosed)
      ->extraAttributes(['class' => 'text-white!'])
      ->action(function () use ($session) {
        $session->finalized = true;
        $session->save();
      })
      ->successNotification(
        Notification::make()
          ->success()
          ->title('Session has been finalized')
          ->body('Now you can schedule your TSC meeting to begin your approval process.')
      );
  }

  private function meetingButtons(ActiveSessionDTO $activeSession) //: Action
  {
    $meetings = MeetingTypeDTO::setMeeting($activeSession->session->meetings);

    $isModal = true;

    if ($meetings->tsc === null || $meetings->spc === null)
      return Action::make($meetings->tsc === null ? 'tsc' : 'spc')
          ->modal()
          ->label('Schedule '. ($meetings->tsc === null ? 'TSC' : 'SPC') .' meeting')
          ->steps(FormService::meetingForm($isModal))
          ->skippableSteps()
          ->fillForm([
            'title' => '',
            'type' => $meetings->tsc === null ? 'tsc' : 'spc',
            'agenda' => '',
            'date' => '',
            'time' => '',
            'venue' => '',
            'participants' => [],
          ])
          ->action(function (array $args) use ($activeSession) {
            logger('', ['args' => $args]);
            // logger('', ['args' => $activeSession->session]);
          })
          ->icon('icon-calendar-time');

    return Action::make('End session')
        ->icon('icon-calendar-check');
  }
}
