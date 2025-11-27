<?php

namespace App\Filament\Resources\Sessions\Pages;

use App\ActiveSessionTrait;
use App\DTO\ActiveSessionDTO;
use App\Filament\Resources\Sessions\SessionResource;
use App\SessionService;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Width;

class ManageSessions extends ManageRecords
{
  use ActiveSessionTrait;

  protected static string $resource = SessionResource::class;

  protected function getHeaderActions(): array
  {
    return [
      !$this->sessionExists() || !$this->sessionIsActive()
        ?
        CreateAction::make()
        ->modal()
        ->modalWidth(Width::Large)
        ->createAnother(false)
        : SessionService::sessionEndButton($this->session),
    ];
  }
}
