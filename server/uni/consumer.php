<?php

namespace server\uni;

use server\uni\db\redis;

/**
 * Description of consumer
 *
 * @author Administrator
 */
class consumer extends platform {

    public static $platform = 'consumer';

    public static function add($group, $host, $data) {
        $data['status'] = 1;
        parent::add($group, $host, $data);
        return service::getGroup($data['service']);
    }

    public static function update($group, $host, $data) {
        parent::update($group, $host, $data);
        return service::getGroup($data['service']);
    }

}
