<?php

namespace web;

/**
 * Description of index
 *
 * @author KKnV_GU
 */
class index {

    public function __construct() {
        
    }

    public function __call($name, $arguments) {
        header("Location:/admin/index");
        exit;
    }

}
