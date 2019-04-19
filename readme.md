# BlueORM 

Simple ORM to manage migrations


## Usage

Has a command to execute some orders.

List commands:

    vendor/bin/blueorm.php
    
Create a migration:

    vendor/bin/blueorm.php migrate:create
    
Execute pending migrations:

    vendor/bin/blueorm.php migrate:up
    
Tear down the last migration:

    vendor/bin/blueorm.php migrate:down
    
Show last migration version name:

    vendor/bin/blueorm.php migrate:last-migration

**blueorm.php** uses a settings file called **blueorm-settings.php** that it's generated on first run.

Includes a base repository called **BaseRepository**

## Database

Have to be initialize using **ConfigDatabase** class by creating a migration.


## Tests

**blueorm-settings.php** must be configured to be able to run tests. It's create at first run

## License

[MIT License](https://opensource.org/licenses/MIT)

## Authors

 - David Moreno Cortina