<?php

namespace App\Constants;

class AppConstants
{

  const EMAIL_TEMPLATE = 'email_templates';
  const SMS_TEMPLATE = 'sms_templates';
  // const SMS_TEMPLATE = 'sms_templates';

  const VAR_REGEX = "/\{\$(\w+)\}/";
  // const VAR_REGEX = "/\{\\$[a-zA-Z_][a-zA-Z]+([a-zA-Z0-9_]+)?\}/";
}
