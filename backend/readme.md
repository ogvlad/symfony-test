# Backend powered by Symfony/PHP

## Prepare database

Download and build the latest versions of the images:

``` docker-compose build --pull --no-cache```

Start Docker Compose in detached mode:

``` docker-compose up -d```

## Code generation

### Entities

Make entity (PHP class):

```php bin/console make:entity```

Make migration (generate SQL script):

```php bin/console make:migration```

Run migration (execute SQL):

```php bin/console doctrine:migrations:migrate```

### Controllers

```php bin/console make:controller```

### Other

```php bin/console make:crud Product```


### VS Code extension

Using this VS Code extension you can easily use `Ctrl+Shift+P` and type `symfony` to pop up the list of available commands.

> https://marketplace.visualstudio.com/items?itemName=nadim-vscode.symfony-super-console


## Run application

```symfony server:start```

## Console commands

If you don't see the `app:parse` listed in console commands try clean the cache which will rebuild the list of available commands:

```php bin/console cache:clear```