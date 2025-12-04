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
  use ActiveSessionTrait;

  public static function sessionEndButton(): Action
  {
    return (new self())->sessionIsFinalized()
      // ? Action::make('End session')
      ? (new self())->meetingButtons()
      : Action::make('Finalize session')
      ->color(Color::Amber)
      ->icon(Heroicon::OutlinedLockClosed)
      ->extraAttributes(['class' => 'text-white!'])
      ->requiresConfirmation()
      ->modalHeading('Finalize Session')
      ->modalDescription(
        '
          Once the session is finalized, you can\'t make any changes to the received application for this session.
          This action cannot be undone. Do you wan to continue with the finalization?
        '
      )
      // ->modalDescription('Are you sure you\'d like to finalize this session?')
      ->modalSubmitActionLabel('Yes, finalize it')
      ->action(function () {
        $session = (new self())->session;
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

  private function meetingButtons() //: Action
  {
    $meetings = MeetingTypeDTO::setMeeting($this->session->meetings);

    if ($meetings->tsc === null || $meetings->spc === null)
      return Action::make($meetings->tsc === null ? 'tsc' : 'spc')
        ->modal()
        ->label('Schedule ' . ($meetings->tsc === null ? 'TSC' : 'SPC') . ' meeting')
        ->color(Color::Orange)
        ->steps(MeetingService::meetingForm())
        ->skippableSteps()
        ->fillForm(MeetingService::formFiller(
          type: $meetings->tsc === null ? MeetingTypeEnum::TSC : MeetingTypeEnum::SPC,
          defaults: ['monthly_session_id' => $this->session->id]
        ))
        ->action(fn(array $data) => MeetingService::saveRecord($data))
        ->icon('icon-calendar-time')
        ->modalWidth(Width::TwoExtraLarge)
        ->successNotification(
          Notification::make()
            ->title('')
        );

    return Action::make('End session')
      ->icon('icon-calendar-check')
      ->color(Color::Red)
      ->requiresConfirmation()
      ->modalHeading('End Session')
      ->modalDescription('Are you sure you\'d like to end this session? This action cannot be undone.')
      ->modalSubmitActionLabel('Yes, end it')
      ->action(function () {
        $this->session->is_current = false;
        $this->session->save();
      })
      ->successNotification(
        Notification::make()
          ->success()
          ->title('Session has been finalized')
          ->body('Now you can schedule your TSC meeting to begin your approval process.')
      );
  }
}
