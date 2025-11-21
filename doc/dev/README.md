
# Clone

```console
$ git clone https://....git
```

# Update
```console
$ composer update
```

# Test
```console
$ php vendor/bin/phpunit --generate-configuration
```

```console
$ php vendor/bin/phpunit --display-all-issues
```

# Create project
```
composer init --name="mysql-workbench/mwb-orm" --description="ORM from MySQL Workbench" --type="library" --author="SVG Animate <glash.gnome@gmail.com>" --stability dev --license="GPL-3.0" --autoload="psr-4"
```

```
{
    "name": "mysql-workbench/mwb-orm",
    "description": "ORM from MySQL Workbench",
    "type": "library",
    "license": "GPL-3.0",
    "autoload": {
        "psr-4": {
            "Mwb\\Orm\\": "src/"
        }
    },
    "authors": [
        {
            "name": "SVG Animate",
            "email": "glash.gnome@gmail.com"
        }
    ],
    "minimum-stability": "dev",
    "repositories": [
        {
            "type": "github",
            "url": "https://github.com/mysql-workbench/mwb-dom"
        }
    ],
    "require": {
        "mysql-workbench/mwb-dom": "^1.0.2"
    }
}
```

Use Singularize in NameingStrategy
```
composer require doctrine/inflector "^2.1"
```
