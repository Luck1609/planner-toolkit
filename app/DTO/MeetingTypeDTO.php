<?php

namespace App\DTO;

use App\Models\Meeting;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class MeetingTypeDTO
{
  /**
   * Create a new class instance.
   */
  public function __construct(
    public ?Meeting $spc = null,
    public ?Meeting $tsc = null,
  ) {}

  public static function setMeeting(Collection $meetings): static
  {
    $meetingData = $meetings
      ->reduce(
        fn($allMeetings, $meeting) => [...$allMeetings, data_get($meeting, 'type')?->value => $meeting],
        []
      );

      logger('', ['meeting-data' => $meetingData]);

    return new static(
      tsc: Arr::get($meetingData, 'tsc', null),
      spc: Arr::get($meetingData, 'spc', null),
    );
  }
}
