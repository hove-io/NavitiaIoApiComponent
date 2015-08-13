NavitiaIoApi Component
=============

PHP library which makes curl calls to NavitiaIo API.


## Composer

Install via composer

``` js
{
    "require": {
        "canaltp/navitiaio-api-component": "1.x"
    }
}
```


## Usage

Instanciate NavitiaIoService as a plain PHP object:

``` php
$navitiaIoApiUrl = 'http://navitia.local/';
$user = 'my_user'
$password = '********'

// Instanciating api
$navitiaIoApiApi = new CanalTP\NavitiaIoApiComponent\NavitiaIoApiService($navitiaIoApiUrl, $user, $password);

// Get users
$response = $navitiaIoApiApi->getUsers();

foreach ($data->users as $user) {
    // Do something here
}
```

See [full NavitiaIoApi class](src/NavitiaIoApiService.php).


### Testing

Mock Guzzle client:

``` php
$navitiaIoApiUrl = 'http://navitiaIoApi.dev.canaltp.fr/v0/';
$user = 'my_user'
$password = '********'

$navitiaIoApiApi = new CanalTP\NavitiaIoApiComponent\NavitiaIoApiService($navitiaIoApiUrl, $user, $password);

// Creating GuzzleHttp\Client mock...

$navitiaIoApiApi->setClient($mockedClient);
```


## License

This project is under [GPL-3.0 License](LICENSE).
