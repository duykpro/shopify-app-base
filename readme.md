## Installation
 - Config API key, secret, scope, app name, app slug in .env
 - run php artisan migrate
 - Config app url as: https://example.com/auth
 - Config app redirection urls as: https://example.com/dashboard
 - Run test install on your development store

## Helpers
 - Making api call: \App\Helpers\Shopify::api($domain)->call($method, $path, (array) $params);