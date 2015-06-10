# budget
A PHP budgeting application that allows you to maintain bills and keep bill History

This budget application allows the user to upload the files to their localhost as a sub_directory and then upload the sql file to the MySQL database.
The user will then edit classes/cxn.php with their MySQL credentials and they will then be all set.

In include_files/configuration.php, be sure and edit the BASE_PATH constant that matches the directory your application is in. EX: 
```php
define("BASE_PATH", "/home-directory/");
```
