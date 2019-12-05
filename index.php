<?php

use Yjtec\Linphe\Core;

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';
require_once 'cfg/route.php';
try {
    Core::start();
} catch (Exception $ex) {
    var_dump($ex);
}
