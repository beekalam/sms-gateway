# sms-gateway

# Api scheme

A postman collection is in `docs' directory.

```
POST http://{{base_url}}/api/v1/send
payload:
{
    mobile:'<mobile_number>',
    message:'some message'
}


GET  http://{{base_url}}/api/v1/report
```

# Admin interface

There's a simple interface for our little sms-gateway
make sure to use `--seed` flag when running migrations to
build the admin user.

the default credentials for admin interface:

```
user: test@example.com
password: 123456
```


# Configurations

Api credentials are configurable in `.env` file.

In addition, since we are using environment
variables  they are configurable via docker if the need arises.

`SMS_PROVIDER` is the name of sms service we want to use.

Example for Kavenegar:

```
SMS_PROVIDER=GHASEDAK

KAVENEGAR_SENDER=100047778
KAVENEGAR_API_KEY=517870714D65584A465A6C67446D43387578504D662B4D696C496631596E6D47565652626237384E6978773D
```

Example for Ghasedak:

```
SMS_PROVIDER=GHASEDAK

GHASEDAK_SENDER=10008566
GHASEDAK_API_KEY=63a5961893d40b7ffcc6fef3dded9030e6f1df65c75dbaab6c8ea89590bd72835
```

## Design decisions

### Since the flow should be async flow we use a queue.

[<img src="docs/design-diagram.png">]("https://github.com/beekalam/sms-gateway")

## adding new providers

When we need to add new sms service to our system we implement `SMSAdapter` interface and
tell the Service Container how to instantiate our new provider. See example.

## Docker workflow

An example config file `.env.docker.example` is provided.

before running with docker `mysql` host should be changed:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
# these are set in docker-compose
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

Queue connection should be `database`
```
# ...
QUEUE_CONNECTION=database
```

### Building


```shell
docker-compose up
docker-compose run --rm composer install
docker-compose run --rm artisan migrate:fresh --seed
docker-compose run --rm npm install
docker-compose run --rm npm run dev
```

### Running tests

```
docker-compose --rm run artisan test
```

## Local development workflow

An example config file `.env.local.example` is provided.

Queue connection should be `database`

```
# ...
QUEUE_CONNECTION=database
```

```
composer install
php artisan migrate:fresh -seed
npm install
npm run dev
php artisan queue:work
php artisan serve
```

### running tests
```
./vendor/bin/phpunit
```

## How to add new sms provider?

- Implement `SMSAdapter.php` interface.

```php
<?php
class AwesomeSMSProvider implement SMSAdapter {
    public const SMS_PROVIDER_NAME = "AWESOME_PROVIDER";

    public function __construct($apiKey,$sender)
    {
        $this->apiKey = $apiKey;
        $this->sender = $sender;
    }

    public function sendMessage()
    {
        // send you message here
        // throw SMSException on erro
    }
}
```

- Add any config values that is needed for your `AwesomeSMSProvider` class to initialize in `.env` file.

```
#....
SMS_PROVIDER=AWESOME_PROVIDER
#....

AWESOME_API_KEY=1233333
AWESOME_SENDER=10001
```

- We use Laravel's default `DI` container. Therefore in `AppServiceProvider.php` we tell the container how our class should be built.

```php
<?php
//....
class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SMSAdapter::class, function () {

            switch (env('SMS_PROVIDER')) {
                // ...
                // Here you tell the container how to build our AwesomeSMSProvider class
                case 'AWESOME_PROVIDER':
                    return new AwesomeSMSProvider(
                        env('AWESOME_API_KEY'),
                        env('AWESOME_SENDER')
                    );
                //...
            }
        });
    }
```
