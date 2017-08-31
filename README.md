# vimbadmin-laravel-client

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

This is a laravel/(lumen?) client library for use with dpslwk/vimbadmin-api

ViMbAdmin is a web based virtual mailbox administration system for dovecote and posftix.

The down side of ViMdAdmin is that it has no APi front end. At Nottingham Hackspace we needed to change our mailbox aliases from the Hackspace Management System (HMS). As the systems run on two different server a quick REST api was thrown together for consumption by HMS 2.0. This is the client package for use in HMS 2.0

* http://github.com/dpslwk/vimbadmin-api
* http://www.vimbadmin.net 
* http://nottinghack.org.uk
* https://github.com/NottingHack/hms2

## Install

Via Composer

``` bash
$ composer require lwk/vimbadmin-laravel-client
```

The following service provider will be autodiscovered for laravel 5.5+. 
```
LWK\ViMbAdmin\ViMbAdminServiceProvider::class,
```

Define setup in .env with the following values

* `VIMBADMIN_URL` - Url for api endpoint
* `VIMBADMIN_ID` - Client Id
* `VIMBADMIN_SECRET` - Client Secret
* `VIMBADMIN_DRIVER` - Token store provider [json, eloquent, doctrine]
* `VIMBADMIN_FILE` - File name for json store
* `VIMBADMIN_MODEL` - Eloquent model
* `VIMBADMIN_ENITITY` - Docrotine Entity

or Publish the config and edit as needed
```
php artisan vendor:publish --provider="LWK\ViMbAdmin\ViMbAdminServiceProvider" --tag=config
```

If using either `eloquent` or `doctrine` token storage db migrations and mappings need to be provided.

## Usage

``` php
$client = App::make(LWK\ViMbAdminClient());
echo $client->findDomains();
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email dps.lwk@gmail.com instead of using the issue tracker.

## Credits

- [Matt Lloyd][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/lwk/vimbadmin-laravel-client.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/lwk/vimbadmin-laravel-client.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/lwk/vimbadmin-laravel-client
[link-downloads]: https://packagist.org/packages/lwk/vimbadmin-laravel-client
[link-author]: https://github.com/dpslwk
[link-contributors]: ../../contributors
