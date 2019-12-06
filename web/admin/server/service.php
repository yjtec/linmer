<?php

namespace web\admin\server;

use web\admin\base;
use server\uni\service as service2;

/**
 * Description of service
 *
 * @author Administrator
 */
class service extends base {

    public function index() {
        $this->display();
    }

    public function getList() {
        $svs = [];
        $services = service2::getAll();
        foreach ($services as $ky => &$service) {
            $svs[] = array_merge(json_decode($service, true), ['key' => $ky]);
        }
        $this->json(1, 'success', $svs);
    }

}
