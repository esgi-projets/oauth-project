<?php
require 'vendor/autoload.php';

use OAuth2\Client;

$config = include 'config.php';

$client = Client::create(
  [
    'client_id' => $config['google']['client_id'],
    'client_secret' =>  $config['google']['client_secret'],
    'redirect_uri' => 'http://localhost:8081',
  ]
);

var_dump($client->getGoogleClient()->getAuthorizationUrl());

$code = $_GET['code'];

$user_info = $client->getGoogleClient()->getUser($code);

var_dump($user_info);
