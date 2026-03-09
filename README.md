# ENV-GUARD 



lets you define a schema for your .env file — think of it like a contract. When your app boots, it checks your actual .env against that contract and fails loudly and early if something is wrong.


```bash
composer require laramicstudio/env-guard
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="env-guard-config"
```

If you are installing on a already existing project you can run the command

```bash
php artisan env:check
```

This is the contents of the published config file:

```php
return [

    'log_rejections' => false,

    'log_channel' => 'stack',

    'rules' => [
        'APP_KEY' => 'required|string',
        'APP_ENV' => 'required|in:local,staging,production',
        'DB_PASSWORD' => 'required|string|min:8',
        'STRIPE_SECRET' => 'required|starts_with:sk_',
        'CACHE_TTL' => 'required|integer|min:1',
        'MAIL_PORT' => 'nullable|integer',
    ],
];
```


## Usage

```php
$envGuard = new LaramicStudio\EnvGuard();
$envGuard->validate();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [hassan lateef](https://github.com/codewithhassan)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
