Settings
========

[![Build Status](https://travis-ci.org/wotek/settings.png?branch=master)](https://travis-ci.org/wotek/settings)
[![Coverage Status](https://coveralls.io/repos/wotek/settings/badge.png?branch=master)](https://coveralls.io/r/wotek/settings?branch=master)
[![Build Status](https://travis-ci.org/wotek/settings.png?branch=develop)](https://travis-ci.org/wotek/settings)
[![Coverage Status](https://coveralls.io/repos/wotek/settings/badge.png?branch=develop)](https://coveralls.io/r/wotek/settings?branch=develop)

Settings library provider simple and easy way to handle settings params in your application. It is able to provide settings from multiple sources across your servers.

## Installation

Installation is fairly simple. We commend using *composer*.

#### Dependencies

Settings library depends on `wotek/redis` which provides support for redis based provider. More on that in documentation.

#### Use composer

If you don't have Composer yet, download it following the instructions on http://getcomposer.org/ or just run the following command:

```
curl -s http://getcomposer.org/installer | php
```

#### Clone repository

If you're not fan of composer. You can just *clone* repository.

```
# Clones repository to settings folder
git clone git@github.com:wotek/settings.git .
```

##### Install Settings library

Run following in root dir of your project:

```
# Composer will automaticaly download & install & modify your composer.json
composer require wotek/settingse:dev-master
```

You've done it ;)


For more information refer documentation in docs/ folder.
