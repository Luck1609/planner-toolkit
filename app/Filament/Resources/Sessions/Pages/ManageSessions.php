<?php

namespace App\Filament\Resources\Sessions\Pages;

use App\DTO\ActiveSessionDTO;
use App\DTO\MeetingTypeDTO;
use App\Enums\MeetingTypeEnum;
use App\Filament\Resources\Sessions\SessionResource;
use App\Services\FormService;
use App\Services\MeetingService;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;

class ManageSessions extends ManageRecords
{
  protected static string $resource = SessionResource::class;

  protected function getHeaderActions(): array
  {
    $activeSession = (new ActiveSessionDTO())();
    return [
      !$activeSession->exists || !$activeSession->active
        ?
        CreateAction::make()
        ->modal()
        ->modalWidth(Width::Large)
        ->createAnother(false)
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

  private function meetingButtons(ActiveSessionDTO $activeSession) //: Action
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
        ->action(fn (array $data) => MeetingService::saveRecord($data))
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
