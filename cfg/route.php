<?php

use Yjtec\Linphe\Router;

if (PHP_SAPI === 'cli') {
    Router::cli("/server(\/.*)*/u", "server\\server", 'start');
} else {
    Router::get("/index/u", "web\\index", 'index');
    Router::get("/login/u", "web\\login", 'index');
    Router::post("/doLogin/u", "web\\login", 'doLogin');
    Router::get("/\//u", "web\\index", 'index');
}