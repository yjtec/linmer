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

    //服务提供者，生产者
    Router::get("/admin\/service/u", "web\\admin\\server\\service", 'index');
    Router::post("/admin\/service/u", "web\\admin\\server\\service", 'getList');
    //服务订阅者，消费者
    Router::get("/admin\/consumer/u", "web\\admin\\server\\consumer", 'index');
    Router::post("/admin\/consumer/u", "web\\admin\\server\\consumer", 'getList');
    //服务更新推送，消费者
    Router::get("/admin\/dispatch/u", "web\\admin\\server\\consumer", 'index');
    Router::post("/admin\/dispatch/u", "web\\admin\\server\\consumer", 'getList');



    Router::get("/index/u", "web\\index", 'index');
    Router::get("/\//u", "web\\index", 'index');
}