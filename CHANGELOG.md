# Changelog

All Notable changes to `ViMbAdminClient` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## 1.2.0 (released 2022-01-23)

### Changed
-- php minimum is now ^7.4, also supports ^8.0
-- support for Laravel 8 & 9 added, removed 5.*
-- Guzzel 7 is now require in place of 6
-- guzzle-oauth2-plugin fork switched (sainsburys -> qbnk) to support Guzzel 7

## 1.1.3 (released 2021-01-11)

### Fixed
- Remove defaults from config
- Separate Guzzle Client for oauth

## 1.1.2 (released 2020-03-06)

### Fixed
- Handle relationships with out data
- Using array_key_exists() on objects is deprecated (php 7.4)


## 1.1.1 (released 2020-01-02)

### Fixed
- break not continue

## 1.1.0 (released 2019-12-21)

### Added
- support for laravel 6

## 1.0.7 (released 2019-01-15)

### Fixed
- fix use of Symfony\Serializer in patch helper, missed this in 1.0.6


## 1.0.6 (released 2018-09-24)

### Fixed
- fix use of Symfony\Serializer in get/put helpers, as we use are own normaliser that does not care about $class argument


## 1.0.5 (released 2017-08-31)

### Added
- support for laravel 5.5 autodiscovery

## 1.0.4 (released 2017-05-28)

### Fixed
- fix mailbox create and upate routines

## 1.0.3 (released 2017-05-17)

### Added
- Mailbox and Alias creation support

## 1.0.2 (released 2017-05-15)

* Delay Guzzel client initialisation until needed

## 1.0.0 (released 2017-05-15)

* First major release

### Added
- Everything

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing
