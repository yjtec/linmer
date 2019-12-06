<?php

namespace web\admin\server;

use web\admin\base;
use server\uni\consumer as consumer2;

/**
 * Description of consumer
 *
 * @author Administrator
 */
class consumer extends base {

    public function index() {
        $this->display();
    }

    public function getList() {
        $svs = [];
        $services = consumer2::getAll();
        foreach ($services as $ky => &$service) {
            $svs[] = array_merge(json_decode($service, true), ['key' => $ky]);
        }
        $this->json(1, 'success', $svs);
    }

}
