<?php

namespace App;

enum MeetingTypeEnum: string
{
  case SPC = 'spc';
  case TSC = 'tsc';
  case CUSTOM = 'custom';
}
