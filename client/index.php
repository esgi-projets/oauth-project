<?php
require 'vendor/autoload.php';

use OAuth2\Client;

function getCode()
{
  return $_GET['code'] ?? null;
}

function getConfig()
{
  return include 'config.php';
}

function getGoogle()
{
  $config = getConfig();
  $google = Client::create(
    [
      'client_id' => $config['google']['client_id'],
      'client_secret' =>  $config['google']['client_secret'],
      'redirect_uri' => 'http://localhost:8081/google',
      'scope' => 'https://www.googleapis.com/auth/userinfo.email',
    ]
  );

  return $google;
}

function getFacebook()
{
  $config = getConfig();
  $facebook = Client::create(
    [
      'client_id' => $config['facebook']['client_id'],
      'client_secret' =>  $config['facebook']['client_secret'],
      'redirect_uri' => 'http://localhost:8081/facebook',
      'scope' => 'email',
    ]
  );

  return $facebook;
}

function getSpotify()
{
  $config = getConfig();
  $spotify = Client::create(
    [
      'client_id' => $config['spotify']['client_id'],
      'client_secret' =>  $config['spotify']['client_secret'],
      'redirect_uri' => 'http://localhost:8081/spotify',
      'scope' => 'user-read-email',
    ]
  );

  return $spotify;
}

function getLocalhost()
{
  $config = getConfig();
  $localhost = Client::create(
    [
      'client_id' => $config['localhost']['client_id'],
      'client_secret' =>  $config['localhost']['client_secret'],
      'redirect_uri' => 'http://localhost:8081/localhost',
    ]
  );

  return $localhost;
}


function getUrls()
{
  $google = getGoogle();

  echo '<pre>';
  echo ('Google : ' . $google->getGoogleClient()->getAuthorizationUrl());
  echo '</pre>';

  $facebook = getFacebook();

  echo '<pre>';
  echo ('Facebook : ' . $facebook->getFacebookClient()->getAuthorizationUrl());
  echo '</pre>';

  $spotify = getSpotify();

  echo '<pre>';
  echo ('Spotify : ' . $spotify->getSpotifyClient()->getAuthorizationUrl());
  echo '</pre>';

  $localhost = getLocalhost();

  echo '<pre>';
  echo ('Localhost : ' . $localhost->getLocalhostClient()->getAuthorizationUrl());
  echo '</pre>';
}

function googleCode()
{
  $code = getCode();
  $google = getGoogle();

  if (!empty($code)) {
    $google_user_info = $google->getGoogleClient()->getUser($code);
    var_dump($google_user_info);
  }
}

function facebookCode()
{
  $code = getCode();
  $facebook = getFacebook();

  if (!empty($code)) {
    $facebook_user_info = $facebook->getFacebookClient()->getUser($code);
    var_dump($facebook_user_info);
  }
}


function spotifyCode()
{
  $code = getCode();
  $spotify = getSpotify();
  $spotify->setScope('');

  if (!empty($code)) {
    $spotify_user_info = $spotify->getSpotifyClient()->getUser($code);
    var_dump($spotify_user_info);
  }
}

function localhostCode()
{
  $code = getCode();
  $localhost = getLocalhost();

  if (!empty($code)) {
    $localhost_user_info = $localhost->getLocalhostClient()->getUser($code);
    var_dump($localhost_user_info);
  }
}

$route = $_SERVER['REQUEST_URI'];
switch (strtok($route, "?")) {
  case '/google':
    googleCode();
    break;
  case '/facebook':
    facebookCode();
    break;
  case '/localhost':
    localhostCode();
    break;
  case '/spotify':
    spotifyCode();
    break;
  default:
    getUrls();
    break;
}
