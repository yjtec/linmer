<?php

namespace cfg;

/**
 * 数据库配置信息
 * @email 18716463@qq.com
 * @version 1.0.0
 */
class Conf {

    const CUR_ENV = 'dev.';
    const UP_OSS = false;
    const DB_CNF = [
        'db_type' => 'pdo',
        'db_user' => 'newup',
        'db_pwd' => 'newup',
        'db_host' => '192.168.1.6',
        'db_port' => '3306',
        'db_name' => 'newup',
        'db_prefix' => ''
    ];
    const ServerHost = '0.0.0.0';
    const Port = ['http' => 9501, 'tcp' => 9502];

}
