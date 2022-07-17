<?php

namespace OAuth2\Clients;

use OAuth2\Clients\AbstractClient;
use Oauth2\Client;

class SpotifyClient extends AbstractClient
{
  public function __construct(Client $oauth)
  {
    // Specific auth informations for Spotify
    $oauth->setAuthUrl('https://accounts.spotify.com/authorize');
    $oauth->setTokenUrl('https://accounts.spotify.com/api/token');
    $oauth->setUserInfoUrl('https://api.spotify.com/v1/me');
    $oauth->setScope($oauth->getScope() ?? '');

    parent::__construct($oauth);
  }
}
