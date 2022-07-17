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

Install dependencies

```bash
  composer install
```

### Run docker

```bash
  docker compose -d
```

## Usage/Examples

Google example :

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

## Demo

Access to http://localhost:8081 directly after starting Docker.
