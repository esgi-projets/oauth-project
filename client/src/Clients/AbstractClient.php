<?php

namespace OAuth2\Clients;

use Exception;
use OAuth2\Client as Client;

abstract class AbstractClient
{
  private $_oauth_client;
  public $_root_key;

  public function __construct(Client $oauth)
  {
    $this->_oauth_client = $oauth;
  }

  public function getOAuthClient()
  {
    return $this->_oauth_client;
  }


  public function getAuthorizationUrl()
  {
    return $this->_oauth_client->getAuthUrl() . '?' . http_build_query([
      'client_id' => $this->_oauth_client->getClientId(),
      'redirect_uri' => $this->_oauth_client->getRedirectUri(),
      'scope' => $this->_oauth_client->getScope(),
      'response_type' => 'code',
    ]);
  }


  public function notSupported()
  {
    throw new Exception('This feature is not accessible in this Class');
  }
}
