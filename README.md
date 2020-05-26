# Laravel Health Check

Package to perform health check analysis based on defined checkers.

## Requirements

- PHP >= 7.2
- Laravel >= 6.0

## Instalation

- Require package with composer:

```bash
composer require letsgoi/laravel-health-check
```

- Publish configuration:

```bash
php artisan vendor:publish --provider="Letsgoi\HealthCheck\HealthCheckServiceProvider" --tag="config"
```

Service Provider will be automatically registered, however if you want to add it manually, you must add this to your `config/app.php` file:

```php
'providers' => [
    // ...
    Letsgoi\HealthCheck\HealthCheckServiceProvider::class,
];
``` 

## Configuration

You must set all checkers that want to pass your application at checkers array on config file (`config/laravel_health_check.php`):

```php
'checkers' => [
    ...
    Letsgoi\HealthCheck\Checkers\DatabaseConnectionChecker::class,
    Letsgoi\HealthCheck\Checkers\WritablePathsChecker::class,
    ...
],
```

You can check any checker without check all, but this configuration is for general check.

## Usage

### Check individual checker

Use `HealthCheck` facade to check an individual checker:

```php
use Letsgoi\HealthCheck\Facades;

HealthCheck::check(new Checker());
```

it will return `true` if check pass and it will throw `HealthCheckerException` if not.

### Check all checkers defined at configuration file

To check all checkers defined at configuration file use `healthCheck` method of `HealthCheck` facade:

```php
use Letsgoi\HealthCheck\Facades;

HealthCheck::healthCheck();
```

it will return `true` if all checks pass and throw `HealthCheckerException` with failed checkers if not.

### Get check errors

If you want to get all check errors of checkers defined at configuration file, you can use `getCheckErrors` method:

```php
use Letsgoi\HealthCheck\Facades;

HealthCheck::getCheckErrors();
```

It returns an array with all errors.

### HealthCheck command

You can run the healthcheck with artisan command:

```bash
php artisan health-check
```

It show ok if all checks pass or exceptions if fails.

### HealthCheck endpoint

You can configure an endpoint to check the health of your app. Configure it on config file (`laravel_health_check`):

```php
...

'endpoint' => [
    'enabled' => env('HEALTH_CHECK_ENDPOINT_ENABLED', true), // Enable/disable endpoint

    'path' => env('HEALTH_CHECK_ENDPOINT_PATH', '/health-check'), // Configure path of endpoint

    'healthy_message' => env('HEALTH_CHECK_ENDPOINT_HEALTHY_MESSAGE', 'Healthy'), // Set ok message
],

...
```

It will return the ok message if all check passed or a server error with the array of errors.

## Checkers

### Available checkers

Those are the available predefined checkers:

- `Letsgoi\HealthCheck\Checkers\AppKeyChecker`: Checks if there is an app key defined as environment variable.
- `Letsgoi\HealthCheck\Checkers\DatabaseConnectionChecker`: Checks if the app can connect with default database connection.
- `Letsgoi\HealthCheck\Checkers\DatabaseMigrationsChecker`: Checks if all migrations are up to date.
- `Letsgoi\HealthCheck\Checkers\DebugChecker`: Checks if the app is not on debug mode.
- `Letsgoi\HealthCheck\Checkers\EnvFileChecker`: Checks if there is an .env file.
- `Letsgoi\HealthCheck\Checkers\WritablePathsChecker`: Checks if the necessary paths are writable.

### Custom checkers

If you need some custom checker (or someone not available yet, PRs are welcome :)), you can do simply implementing the `Letsgoi\HealthCheck\Contracts\HealthChecker` contract.

It forces to implement a `check` method that returns `true` if check pass or `false` if not.

Then you can use normally adding to your config file or checking it with individual mode.

## Testing

Run tests:

```bash
composer test
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](./LICENSE)
