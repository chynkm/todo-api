# TODO API

## Requirements
- PHP v7.4
- Composer v2.1.8

## Installation steps

### Production environment
- Update values for Production in the file `config/settings.php`
- `composer install --no-dev --optimize-autoloader`
- Web root should point to the `public/` directory.

### Development environment
- `composer install`
- Running tests: `composer test`
- Running the application with in Built-in web server: `php -S 127.0.0.1:8080 -t public`
- Point your browser address bar to `http://127.0.0.1:8080/docs` to view the API specifications


## Configuring database
- I have used MariaDB v10.5
- Create database and/or update the values of `$settings['db']` in `config/settings.php`

### Create table
```
DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `completed` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

Import the folllwing classes in `config/container.php`
```
use App\Infrastructure\Persistence\Task\MariaDBTaskRepository;
use Doctrine\DBAL\Configuration as DoctrineConfiguration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
```

Add the following connection info in the `return [` block
```
    // Database connection
    Connection::class => function (ContainerInterface $container) {
        $config = new DoctrineConfiguration();
        $connectionParams = $container->get('settings')['db'];

        return DriverManager::getConnection($connectionParams, $config);
    },

    TaskRepository::class => function (ContainerInterface $container) {
        return $container->get(MariaDBTaskRepository::class);
    },
```

Remove the following from the `return [` block
```
    TaskRepository::class => function (ContainerInterface $container) {
        return $container->get(InMemoryTaskRepository::class);
    },
```

**Note**: I have assumed that users will only have access to their tasks.
