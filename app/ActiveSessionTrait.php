<?php

namespace App;

use App\DTO\MeetingTypeDTO;
use App\Models\MonthlySession;

trait ActiveSessionTrait
{
  protected ?MonthlySession $session;

  public function __construct()
  {
    $this->session = MonthlySession::where('is_current', true)
      ->first();
  }

  protected function sessionExists() : bool
  {
    return $this->session !== null;
  }

  protected function sessionIsFinalized() : bool
  {

    $finalized = $this->session?->finalized ?: false;
    logger('', ['session-finalized' => $finalized]);
    return $finalized;
  }

  protected function sessionIsActive() : bool
  {
    return $this->session?->is_current ?: false;
  }

  protected function sessionMeeting(): MeetingTypeDTO
  {
    return MeetingTypeDTO::setMeeting($this->session->meetings);
  }
}
