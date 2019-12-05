<?php

use Yjtec\Linphe\Router;

if (PHP_SAPI === 'cli') {
    Router::cli("/server(\/.*)*/u", "server\\server", 'start');
} else {
    Router::get("/admin\/index/u", "web\\admin\\index", 'index');


    //登录登出
    Router::get("/admin\/login/u", "web\\admin\\login", 'index');
    Router::post("/admin\/login/u", "web\\admin\\login", 'doLogin');
    Router::get("/admin\/logout/u", "web\\admin\\login", 'logout');
    Router::get("/admin\/upPwd/u", "web\\admin\\admin", 'upPwd');
    Router::post("/admin\/upPwd/u", "web\\admin\\admin", 'doUpPwd');





    Router::get("/index/u", "web\\index", 'index');
    Router::get("/\//u", "web\\index", 'index');
}