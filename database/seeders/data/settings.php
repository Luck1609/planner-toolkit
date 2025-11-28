<?php
return [
  [
    "name" => "permissions",
    "value" => [
      [
        "name" => "Localities",
        "actions" => [
          "View locality page",
          "Create new locality",
          "Update existing locality",
          "Delete locality"
        ]
      ],
      [
        "name" => "Sectors",
        "actions" => [
          "View sector page",
          "Add new image to sector",
          "Update existing sector details",
          "Delete sector"
        ]
      ],
      [
        "name" => "Users",
        "actions" => [
          "View users page",
          "Add new user",
          "Update existing user information",
          "Delete user from the app"
        ]
      ],
      [
        "name" => "Session",
        "actions" => [
          "View session page",
          "Add new session",
          "Update existing session details",
          "Delete session from catalogue"
        ]
      ],
      [
        "name" => "Meeting",
        "actions" => [
          "View meetings",
          "Schedule a meeting",
          "Delete meeting records",
          "Update meeting records"
        ]
      ],
      [
        "name" => "Committee",
        "actions" => [
          "View committees",
          "Create new committee",
          "Update existing committee",
          "Delete existing committee"
        ]
      ],
      [
        "name" => "Message",
        "actions" => [
          "View received messages",
          "Reply messages",
          "Delete messages"
        ]
      ],
      [
        "name" => "Role",
        "actions" => [
          "Create new role",
          "update existing role",
          "Delete roles",
          "Assign role to user"
        ]
      ]
    ],
  ],
  [
    "name" => "sms_templates",
    "value" => [
      'received' => [
        'message' => 'Hello [APPLICANT_TITLE]  [APPLICANT_LASTNAME] \nThis message is to acknowledge the receipt of your permit application submitted to [OFFICE_NAME] \n\nFor any enquiries, please call [OFFICE_PHONE]',
        'title' => 'application_status',
        'description' => 'Customize the SMS sent when an application is received',
      ],
      'recommended' => [
        'message' => 'Congratulations [APPLICANT_TITLE]  [APPLICANT_LASTNAME] \nThis message is to acknowledge the receipt of your permit application submitted to [OFFICE_NAME] has been recommended for approval. \n\nFor any enquiries, please call [OFFICE_PHONE]',
        'title' => 'application_status',
        'description' => 'Customize the SMS sent when an application is recommended',
      ],
      'approved' => [
        'message' => 'Congratulations [APPLICANT_TITLE]  [APPLICANT_LASTNAME] \nThis message is to acknowledge the receipt of your permit application submitted to [OFFICE_NAME] is ready for collection. \n\nFor any enquiries, please call [OFFICE_PHONE]',
        'title' => 'application_status',
        'description' => 'Customize the SMS sent when an application is approved',
      ],
      'deferred' => [
        'message' => 'Hello [APPLICANT_TITLE]  [APPLICANT_LASTNAME] \nThis message is to acknowledge the receipt of your permit application submitted to [OFFICE_NAME] has been deferred. \n\nFor any enquiries, please call [OFFICE_PHONE]',
        'title' => 'application_status',
        'description' => 'Customize the SMS sent when an application is deferred',
      ],
      'refused' => [
        'message' => 'Hello [APPLICANT_TITLE]  [APPLICANT_LASTNAME] \nThis message is to acknowledge the receipt of your permit application submitted to [OFFICE_NAME] has been refused. \n\nFor any enquiries, please call [OFFICE_PHONE]',
        'title' => 'application_status',
        'description' => 'Customize the SMS sent when an application is refused',
      ],
      'meeting' => [
        'message' => 'Dear [TITLE] [LASTNAME] you are kindly invited to attend a meeting on [MEETING_TITLE] scheduled on [DATE] [TIME] at [VENUE]',
        'title' => 'meeting_invitation',
        'description' => 'Customize the invitation SMS sent to meeting participants',
      ]
    ],
  ],
  [
    "name" => "otp",
    "value" => 30, //Set duration when OTP is valid default (30)mins"
  ],
  [
    "name" => "titles",
    "value" => [
      'Mr.',
      'Mrs.',
      'Ms.',
      'Pln.',
      'Dr.',
      'Eng.',
      'Prof.',
      'Esq.'
    ],
  ],
  [
    "name" => "committee-roles",
    "value" => [
      'Chairman',
      'Secretary',
      'Member',
      'Co-opted member',
      'Others'
    ],
  ],
  [
    "name" => "office",
    "value" => [
      'name' => '',
      'region' => '',
      'district' => '',
      'initials' => '',
      'address' => '',
      'shelves' => '',
      'email' => '',
    ]
  ],
  [
    'name' => 'notifications',
    'value' => [
      'application_status' => [
        'received' => [
          'sms' => true,
          'email' => false
        ],
        'recommended' => [
          'sms' => true,
          'email' => false
        ],
        'approved' => [
          'sms' => true,
          'email' => false
        ],
        'deferred' => [
          'sms' => true,
          'email' => false
        ],
        'refused' => [
          'sms' => true,
          'email' => false
        ],
      ],
      ''
    ]
  ],
  [
    'name' => 'application-status',
    'value' => [
      [
        'name' => 'Approve',
        'sort_order' => 1,
        'state' => 'approved',
        'color' => 'primary'
      ],
      [
        'name' => 'Recommend',
        'sort_order' => 2,
        'state' => 'recommended',
        'color' => 'success'
      ],
      [
        'name' => 'Defer',
        'sort_order' => 3,
        'state' => 'deferred',
        'color' => 'warning'
      ],
      [
        'name' => 'Reject',
        'sort_order' => 4,
        'state' => 'rejected',
        'color' => 'danger'
      ],
    ]
  ]
  // [
  //   'name' => 'google_storage',
  //   'value' => [
  //     'access_token' => '',
  //     'refresh_token' => '',
  //     'token_expires_at' => '',
  //     'email' => ''
  //   ]
  // ],
];
