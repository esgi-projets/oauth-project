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

  protected function getAccessToken(string $code, string $method = 'GET', $options = [])
  {
    $options = array_merge([
      'code' => $code,
      'grant_type' => 'authorization_code',
      'client_id' => $this->_oauth_client->getClientId(),
      'client_secret' => $this->_oauth_client->getClientSecret(),
      'redirect_uri' => $this->_oauth_client->getRedirectUri(),
    ], $options);
    $response = $this->_oauth_client->call($this->_oauth_client->getTokenUrl(), $method, $options);
    return json_decode($response->text(), true)['access_token'];
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

  public function getUser($code)
  {
    $access_token = $this->getAccessToken($code, 'POST');

    $headers = [
      ['Authorization', 'Bearer' . $access_token],
    ];

    $this->_oauth_client->setHeaders($headers);

    $response = $this->_oauth_client->call($this->_oauth_client->getUserInfoUrl(), 'GET');

    return json_decode($response->text(), true);
  }

  public function notSupported()
  {
    throw new Exception('This feature is not accessible in this Class');
  }
}
