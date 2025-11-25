<?php

namespace App\Enums;

enum MeetingTypeEnum: string
{
  case SPC = 'spc';
  case TSC = 'tsc';
  case CUSTOM = 'custom';
}
