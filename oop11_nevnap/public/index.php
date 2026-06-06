<?php
//18:18, 18:45

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// require_once "vendor/autoload.php";
// require_once __DIR__ . '/vendor/autoload.php';
// require_once __DIR__ . '/../../vendor/autoload.php';

require_once __DIR__ . '/../vendor/autoload.php';

header("Content-Type: application/json; charset=utf-8");

use App\Controllers\NameDayController;

$peldany1 = new NameDayController();
print json_encode($peldany1->handleRequest(), JSON_UNESCAPED_UNICODE);


?>