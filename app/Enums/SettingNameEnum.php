<?php

namespace App\Enums;

enum SettingNameEnum: string
{
  case PERMISSIONS = 'permissions';
  case SMS_TEMPLATE = 'sms-template';
  case GENERAL = 'general';
  case NOTIFICATIONS = 'notifications';
  case TITLES = 'titles';
  case COMMITTEE_ROLES = 'committee-roles';
  case APPLICATION_STATUS = 'application-status';
  case OFFICE = 'office';
}
