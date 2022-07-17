<?php

namespace OAuth2\Clients;

use OAuth2\Clients\AbstractClient;
use Oauth2\Client;

class FacebookClient extends AbstractClient
{
  private $_oauth_client;
  public function __construct(Client $oauth)
  {
    // Specific auth informations for Facebook
    $oauth->setAuthUrl('https://www.facebook.com/v14.0/dialog/oauth');
    $oauth->setTokenUrl('https://graph.facebook.com/v14.0/oauth/access_token');
    $oauth->setUserInfoUrl('https://graph.facebook.com/me?fields=id,name,email');
    $oauth->setScope($oauth->getScope() ?? '');

    $this->_oauth_client = $oauth;

    parent::__construct($oauth);
  }

  public function getUser($code)
  {
    $access_token = $this->getAccessToken($code, 'GET');

    $this->_oauth_client->setHeaders([
      ['Authorization', 'Bearer ' . $access_token],
    ]);

    $response = $this->_oauth_client->call($this->_oauth_client->getUserInfoUrl(), 'GET');

    return json_decode($response->text(), true);
  }
}
