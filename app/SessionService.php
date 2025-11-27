<?php

namespace App;


use App\DTO\ActiveSessionDTO;
use App\DTO\MeetingTypeDTO;
use App\Enums\MeetingTypeEnum;
use App\Models\MonthlySession;
use App\Services\MeetingService;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;

class SessionService
{
  public static function sessionEndButton(MonthlySession $session): Action
  {
    return $session->finalized
      // ? Action::make('End session')
      ? (new self())->meetingButtons($session)
      : Action::make('Finalize session')
      ->color(Color::Amber)
      ->icon(Heroicon::OutlinedLockClosed)
      ->extraAttributes(['class' => 'text-white!'])
      ->requiresConfirmation()
      ->modalHeading('Finalize Session')
      ->modalDescription('Are you sure you\'d like to finalize this session? This action cannot be undone.')
      ->modalSubmitActionLabel('Yes, finalize it')
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

  private function meetingButtons(MonthlySession $activeSession) //: Action
  {
    $session = $activeSession->session;
    $meetings = MeetingTypeDTO::setMeeting($session->meetings);

    if ($meetings->tsc === null || $meetings->spc === null)
      return Action::make($meetings->tsc === null ? 'tsc' : 'spc')
        ->modal()
        ->label('Schedule ' . ($meetings->tsc === null ? 'TSC' : 'SPC') . ' meeting')
        ->steps(MeetingService::meetingForm())
        ->skippableSteps()
        ->fillForm(MeetingService::formFiller(
          type: $meetings->tsc === null ? MeetingTypeEnum::TSC : MeetingTypeEnum::SPC,
          defaults: ['monthly_session_id' => $activeSession->session->id]
        ))
        ->action(fn(array $data) => MeetingService::saveRecord($data))
        ->icon('icon-calendar-time')
        ->modalWidth(Width::TwoExtraLarge);

    return Action::make('End session')
      ->icon('icon-calendar-check')
      ->color(Color::Red)
      ->requiresConfirmation()
      ->modalHeading('End Session')
      ->modalDescription('Are you sure you\'d like to end this session? This action cannot be undone.')
      ->modalSubmitActionLabel('Yes, end it')
      ->action(function () use ($session) {
        $session->is_current = false;
        $session->save();
      })
      ->successNotification(
        Notification::make()
          ->success()
          ->title('Session has been finalized')
          ->body('Now you can schedule your TSC meeting to begin your approval process.')
      );
  }
}
