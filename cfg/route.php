<?php

use lib\Core\Router;

Router::cli("/server(\/.*)*/u", "server\\server", 'start');
Router::cli("/web(\/.*)*/u", "web\\server", 'start');



Router::get("/index/u", "web\\index", 'index');
Router::get("/\//u", "web\\index", 'index');
