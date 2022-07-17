<?php

namespace OAuth2\Clients;

use OAuth2\Clients\AbstractClient;
use Oauth2\Client;

class LocalServerClient extends AbstractClient
{
  private $_oauth_client;
  public function __construct(Client $oauth)
  {
    // Specific auth informations for local server
    $oauth->setAuthUrl('http://localhost:8080/auth');
    $oauth->setTokenUrl('http://oauth-server:8080/token');
    $oauth->setUserInfoUrl('http://oauth-server:8080/me');
    $oauth->setScope($oauth->getScope() ?? '');
    $oauth->setState($oauth->getState() ?? 'authorization_code');

    $this->_oauth_client = $oauth;

    parent::__construct($oauth);
  }

  public function getUser($code)
  {
    $access_token = $this->getAccessToken($code, 'GET');

    $headers = [
      ['Authorization', 'Bearer ' . $access_token],
    ];

    $this->_oauth_client->setHeaders($headers);

    $response = $this->_oauth_client->call($this->_oauth_client->getUserInfoUrl(), 'GET');

    return json_decode($response->text(), true);
  }
}
