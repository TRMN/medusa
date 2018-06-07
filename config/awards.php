<?php
/**
 * Set some sensible defaults for award notifications
 */
return [
  'MCAM-notification' => [
      'email' => env('MCAM_EMAIL', 'cos@sia.trmn.org'),
      'subject' => env('MCAM_SUBJECT', '[MEDUSA notification] MCAM qualification: '),
  ],
  'SWP-notification' => [
      'email' => env('SWP_EMAIL', 'provostmarshal@sia.trmn.org'),
      'subject' => env('SWP_SUBJECT', '[MEDUSA notification] SWP qualifications for '),
  ],
  'from' => [
      'address' => env('AWARD_FROM_ADDRESS', 'awardnotificaton@trmn.org'),
      'name' => env('AWARD_FROM_NAME', 'MEDUSA Award Notification'),
  ],
  'display_days' => env('DAYS_TO_ADD', 2),
];