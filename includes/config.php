<?php
//App Root
define('APP_NAME', $_ENV['APP_NAME']);
define('APP_URL', $_ENV['APP_URL']);
define('APP_ROOT', dirname(__FILE__, 2));

//DB Params
define('DB_CONNECTION', $_ENV['DB_CONNECTION']);
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_PORT', $_ENV['DB_PORT']);
define('DB_SERVICE', $_ENV['DB_SERVICE']);
define('DB_DATABASE', $_ENV['DB_DATABASE']);
define('DB_USERNAME', $_ENV['DB_USERNAME']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
define('DB_DSN', $_ENV['DB_DSN']);
