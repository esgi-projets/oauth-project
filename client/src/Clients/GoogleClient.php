<?php

namespace OAuth2\Clients;

use OAuth2\Clients\AbstractClient;
use Oauth2\Client;

class GoogleClient extends AbstractClient
{
  public function __construct(Client $oauth)
  {
    // Specific auth informations for Google
    $oauth->setAuthUrl('https://accounts.google.com/o/oauth2/v2/auth');
    $oauth->setTokenUrl('https://oauth2.googleapis.com/token');
    $oauth->setUserInfoUrl('https://www.googleapis.com/oauth2/v1/userinfo');
    $oauth->setRedirectUri('http://localhost:8081');
    $oauth->setScope($oauth->getScope() ?? 'email');

    parent::__construct($oauth);
  }
}
