# ViMbAdminClient

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This is a laravel/(lumen?) client library for use with dpslwk/vimbadmin-api

ViMbAdmin is a web based virtual mailbox administration system for dovecote and posftix.

The down side of ViMdAdmin is that it has no APi front end. At Nottingham Hackspace we needed to change our mailbox aliases from the Hackspace Management System (HMS). As the systems run on two different server a quick REST api was thrown together for consumption by HMS 2.0. This is the client package for use in HMS 2.0

* http://github.com/dpslwk/vimbadmin-api
* http://www.vimbadmin.net 
* http://nottinghack.org.uk
* https://github.com/NottingHack/hms2

## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practises by being named the following.

```
bin/        
config/
src/
test/
vendor/
```


## Install

Via Composer

``` bash
$ composer require dpslwk/ViMbAdminClient
```

Add the following to your `config/app.php` service provider list. 
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

or Publish the config
```
php artisan vendor:publish --provider="LWK\ViMbAdmin\ViMbAdminServiceProvider" --tag=config
```

If using either `eloquent` or `doctrine` token storage db migrations and mappings need to be provided.

## Usage

``` php
$skeleton = new LWK\ViMbAdmin();
echo $skeleton->echoPhrase('Hello, League!');
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

[ico-version]: https://img.shields.io/packagist/v/dpslwk/ViMbAdminClient.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/dpslwk/ViMbAdminClient/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/dpslwk/ViMbAdminClient.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/dpslwk/ViMbAdminClient.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/dpslwk/ViMbAdminClient.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/dpslwk/ViMbAdminClient
[link-travis]: https://travis-ci.org/dpslwk/ViMbAdminClient
[link-scrutinizer]: https://scrutinizer-ci.com/g/dpslwk/ViMbAdminClient/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/dpslwk/ViMbAdminClient
[link-downloads]: https://packagist.org/packages/dpslwk/ViMbAdminClient
[link-author]: https://github.com/dpslwk
[link-contributors]: ../../contributors
