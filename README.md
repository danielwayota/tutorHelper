# CodeIgniter Tutor Helper 3000

This website is made for a personal tutor. 
Can be used to organise the lessons of each month and generate a monthly report.

## HTTP Server setup

Set the URL to be used for the app in `application/config/config.php`
```php
$config['base_url'] = 'http://yourserver:<port>';
```

## Database setup

The full MySQL script is `tutorHelper.sql`. It needs an existing database, the name doesn't matter.
The db server configuration, should be written in `application/config/database.php` file.

There is some default data: hours, schedules and a single superuser.
Superuser default credentials:
- email: admin@admin.es
- password: Password
