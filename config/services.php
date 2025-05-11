<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Third Party Services
  |--------------------------------------------------------------------------
  |
  | This file is for storing the credentials for third party services such
  | as Mailgun, Postmark, AWS and more. This file provides the de facto
  | location for this type of information, allowing packages to have
  | a conventional file to locate the various service credentials.
  |
  */

  'postmark' => [
    'token' => env('POSTMARK_TOKEN'),
  ],

  'ses' => [
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
  ],

  'slack' => [
    'notifications' => [
      'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
      'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
    ],
  ],

  'steadfast' => [
    'api_key' => env('STEADFAST_API_KEY', 'iuvwugflykjmmsp12yvann6gk3a0z4uj '),
    'secret_key' => env('STEADFAST_SECRET_KEY', 'q53cmjemobtksmebiosph15d '),
    'delivery_company_id' => env('STEADFAST_DELIVERY_COMPANY_ID', '5'),
  ],

];
