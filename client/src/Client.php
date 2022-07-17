<?php

namespace OAuth2;

use OAuth2\Clients\FacebookClient;
use OAuth2\Clients\GoogleClient;
use OAuth2\Clients\LocalServerClient;
use OAuth2\Clients\SpotifyClient;
use OAuth2\Curl as CurlClient;

class Client
{
  // Local informations
  private static $_client_id;
  private static $_client_secret;
  private static $_auth_url;
  private static $_token_url;
  private static $_user_info_url;
  private static $_redirect_uri;
  private static $_scope;
  private static $_state;

  private static $_client;
  private static $_headers;

  // Returned by the API
  private static $_auth;

  public function getClientId()
  {
    return self::$_client_id;
  }

  public function getClientSecret()
  {
    return self::$_client_secret;
  }

  public function getAuthUrl()
  {
    return self::$_auth_url;
  }

  public function getTokenUrl()
  {
    return self::$_token_url;
  }

  public function getRedirectUri()
  {
    return self::$_redirect_uri;
  }

  public function getUserInfoUrl()
  {
    return self::$_user_info_url;
  }

  public function getAuth()
  {
    return self::$_auth;
  }

  public function getHeaders()
  {
    return self::$_headers;
  }

  public function getScope()
  {
    return self::$_scope;
  }

  public function getState()
  {
    return self::$_state;
  }

  public static function getClient(array $auth = [])
  {
    if (!static::$_client) {
      static::$_client = static::create($auth);
    }

    return static::$_client;
  }

  public function getHttpClient()
  {
    $options = [];

    return new CurlClient($options);
  }

  public function setClientId(string $client_id)
  {
    self::$_client_id = $client_id;
  }

  public function setClientSecret(string $client_secret)
  {
    self::$_client_secret = $client_secret;
  }

  public function setAuthUrl(string $auth_url)
  {
    self::$_auth_url = $auth_url;
  }

  public function setTokenUrl(string $token_url)
  {
    self::$_token_url = $token_url;
  }

  public function setRedirectUri(string $redirect_uri)
  {
    self::$_redirect_uri = $redirect_uri;
  }

  public function setUserInfoUrl(string $user_info_url)
  {
    self::$_user_info_url = $user_info_url;
  }

  public function setAuth(array $auth)
  {
    self::$_auth = $auth;
  }

  public function setHeaders(array $headers)
  {
    self::$_headers = $headers;
  }

  public function setScope(string $scope)
  {
    self::$_scope = $scope;
  }

  public function setState(string $state)
  {
    self::$_state = $state;
  }

  public function getGoogleClient()
  {
    return new GoogleClient($this);
  }

  public function getFacebookClient()
  {
    return new FacebookClient($this);
  }

  public function getSpotifyClient()
  {
    return new SpotifyClient($this);
  }

  public function getLocalhostClient()
  {
    return new LocalServerClient($this);
  }

  // Initialize the connection to the API
  public static function create(array $auth)
  {
    $client = new static();

    if (!isset($auth['client_id'])) {
      throw new \Exception('The client_id is required');
    }

    if (!isset($auth['client_secret'])) {
      throw new \Exception('The client_secret is required');
    }

    if (!isset($auth['redirect_uri'])) {
      throw new \Exception('The redirect_uri is required');
    }

    if (!isset($auth['scope'])) {
      $client->setScope('');
    } else {
      $client->setScope($auth['scope']);
    }

    $client->setClientId($auth['client_id']);
    $client->setClientSecret($auth['client_secret']);
    $client->setRedirectUri($auth['redirect_uri']);


    return $client;
  }

  public function call($url, $method = 'GET', $body = [])
  {
    $client = $this->getHttpClient();

    if (!empty($this->getHeaders())) {
      $client->appendRequestHeaders($this->getHeaders());
    }

    $response = $client->$method($url, $body);

    return $response;
  }
}
