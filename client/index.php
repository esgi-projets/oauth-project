<?php
require 'vendor/autoload.php';

use OAuth2\Client;

$client = Client::create(
  [
    'client_id' => '752856717798-0d2hh4pjr8cceeqhmrb9sivvaijneg9i.apps.googleusercontent.com',
    'client_secret' => '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',
  ]
);

var_dump($client->getGoogleClient()->getAuthorizationUrl());

$code = $_GET['code'];

$user_info = $client->getGoogleClient()->getUser($code);

var_dump($user_info);
