<?php

namespace web\admin\server;

use web\admin\base;
use server\uni\dispatch as dispatch2;

/**
 * Description of consumer
 *
 * @author Administrator
 */
class dispatch extends base {

    public function index() {
        $this->display();
    }

    public function getList() {
        $svs = [];
        $services = dispatch2::getAll();
        foreach ($services as $ky => &$service) {
            $svs[] = array_merge(json_decode($service, true), ['key' => $ky]);
        }
        $this->json(1, 'success', $svs);
    }

}
