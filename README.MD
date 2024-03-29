# OAuth Project 3IW2

## Authors

- [@btnalexandre](https://www.github.com/btnalexandre)
- [@LouisAntoine](https://www.github.com/louisantoine)

## Providers

- Google
- Spotify
- Facebook
- Local server

## Run Locally

### Clone the project

```bash
  git clone https://github.com/esgi-projets/oauth-project
```

### Go to the project directory

Install dependencies in the `client` directory

```bash
  composer install
```

### Run docker

Execute this command at the root of the project :

```bash
  docker compose -d
```

## Usage/Examples

**Use environment variables to prevent code leak !**

You can see an example for all providers in the index.php : [here](https://github.com/esgi-projets/oauth-project/blob/master/client/index.php)

#### Example for Google :

```php
require 'vendor/autoload.php';

use OAuth2\Client;

$google = Client::create(
    [
      'client_id' => 'your env credential',
      'client_secret' =>  'your env secret',
      'redirect_uri' => 'http://localhost:8081/google',
      'scope' => 'https://www.googleapis.com/auth/userinfo.email',
    ]
);

// Get Authorization Url

echo ('Google : ' . $google->getGoogleClient()->getAuthorizationUrl());

// Get user info after auth on Google
$code = $_GET['code'] ?? null;

if (!empty($code)) {
    $google_user_info = $google->getGoogleClient()->getUser($code);
    var_dump($google_user_info);
}

```

## Add multiples providers

You can add another providers by creating a class in the folder `client/src/Clients`

- Create a class and `extends AbstractClient`

- Add a `__construct` function and set URLs for this provider

- If the provider have a specific behavior and you want to modify a specific function related to the AbstractClient, you can override by adding them to the provider Class generated by you.

#### Example for Google :

```php
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
    $oauth->setScope($oauth->getScope() ?? '');

    parent::__construct($oauth);
  }
}
```

**Don't forget to instance the class in `Client.php`** :

```php
use OAuth2\Clients\GoogleClient;

 public function getGoogleClient()
  {
    return new GoogleClient($this);
  }
```

After that you can use the provider like that :

```php

$client = Client::create(
    [
      'client_id' => 'your client id',
      'client_secret' =>  'your client secret',
      'redirect_uri' => 'your redirect uri',
      'scope' => 'your scope',
    ]
);

$googleClient = $client->getGoogleClient();

...
```

## Demo

Access to http://localhost:8081 directly after starting Docker.
