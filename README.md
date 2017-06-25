# zenmoney-php-api-library

To receive a `consumer_key` and `consumer_secret`, register a new application at http://developers.zenmoney.ru/index.html

```php
use Ryadnov\ZenMoney\Api\Auth\OAuth2;
use Ryadnov\ZenMoney\Api\V8\RequestDiff;

$auth       = new OAuth2([
    'consumer_key'    => 'XXXXXXXX',
    'consumer_secret' => 'XXXXXXXX',
    'username'        => 'XXXXXXXX',
    'password'        => 'XXXXXXXX',
]);
$token_info = $auth->getToken();

$request = new RequestDiff([
    'token' => $token_info['access_token'],
]);
$data    = $request->execute([
    'serverTimestamp' => 0, // first sync
]);
```
