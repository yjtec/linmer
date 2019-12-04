<?php

namespace lib\service;

use lib\baseSvc;

/**
 * Description of service
 *
 * @author Administrator
 */
class service extends baseSvc {

    private static $instance;
    public $svMd;

    private function __construct() {
        parent::__construct();
        $this->svMd = new serviceMd();
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get() {
        return $this->svMd->getById(1);
    }

}
