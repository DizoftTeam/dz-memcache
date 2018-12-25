# Dz MemCache for Yii2

MemCache component for Yii2 projects

Current version -> 1.0.1

## Instalation

Add in `composer.json` following:

```json
{
    "require": {
        "dz/memcache": "1.0.*"
    },
    "repositories": [
        {
            "type": "git",
            "url": "git@gitlab.com:dz-web/dz-memcache.git"
        }
    ]
}
```

And run `composer update`

## How to use

In Yii2 config add in **components** section:

```php
    'cache' => [
        'class' => 'dz\memcache\MemCache',
            'useMemcached' => true,
            'persistentId' => 'project_cache',
            'options' => [
                Memcached::OPT_PREFIX_KEY => 'app_project_cache',
                Memcached::OPT_DISTRIBUTION => Memcached::DISTRIBUTION_CONSISTENT
            ],
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211
                ]
            ]
        ],
    ],
```
