<?php

namespace cfg;

/**
 * 数据库配置信息
 * @email 18716463@qq.com
 * @version 1.0.0
 */
class Conf {

    const CUR_ENV = 'dev.';
    const DB_CNF = [
        'host' => '127.0.0.1',
        'port' => '6379',
        'prefix' => 'linmer_'
    ];
    const ServerHost = '0.0.0.0';
    const Port = ['http' => 9501, 'tcp' => 9502];
    const ServiceHeartBeatTime = 1000;
    const ConsumerDispatchTime = 1000;

//    const PlantformService = 'service';
//    const PlantformConsumer = 'consumer';
//    const ServiceEvent = ['register', 'delete', 'update', 'check'];
//    const ConsumerEvent = ['register', 'update'];
}
