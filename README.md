# PPRG
This uses a PHP framework I created to fetch and show the most popular PHP repos on Github

## Installation

```bash
Download the repo and upload it to a server running PHP
Set the site root to point to the public folder
Use the sql file in the migrations folder to set up the database table necessary to run the app
When the site can be reached, point to the <SITE URL>/reset-repos/ endpoint to populate the database table
```

## Requirements
```bash
- Web Server - Tested on Apache with mod_rewrite enabled
    If a different server is used, some sort of URL rewrite rules will need to be in place to manage dynamic routing
- PHP - 7+ (tested on 7.4.1)
- MySQL 5.7+
```

## Basic Architecture
This framework uses an MVC type approach with all of the basic configurations managed in the app folder

Database configuration can be found in the /app/config.php file

All code is filtered through the /public/index.php file

The /public/views/ folder will contain the view files

The /controllers/ folder will contain the files to manage code logic between the views and the database (models)

The /models/ folder will contain the files to manage database integration

The /app/app.php files contains all of the framework logic

The /app/db.php file contains a database class that abstracts basic database query functions

The /app/config.php file contains all of the basic configurations for the site that can be customized

The /app/routes.php file is used to manage URL routes

HTMLPurifier is used to help prevent against XSS SQL injection

## License
[MIT](https://choosealicense.com/licenses/mit/)
