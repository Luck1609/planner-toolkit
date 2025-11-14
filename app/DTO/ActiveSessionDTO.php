<?php

namespace App\DTO;

use App\Models\MonthlySession;

class ActiveSessionDTO
{
  /**
   * Create a new class instance.
   */
  public function __construct(
    public bool $exists = false,
    public bool $finalized = false,
    public bool $active = false,
    public ?MonthlySession $session = null
  ) {}

  public function __invoke(): static
  {
    $session = MonthlySession::where('is_current', true)
      ->first();

    return new static(
      exists: $session !== null,
      session: $session,
      finalized: $session->finalized,
      active: $session->is_current,
    );
  }
}
