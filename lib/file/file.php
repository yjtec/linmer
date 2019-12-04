<?php

namespace lib\file;

/**
 * Description of file
 *
 * @author KKnV_GU
 */
class file {

    public function read($path) {
        $content = file_get_contents($path);
        return json_decode($content, true);
    }

    public function write($path, $data) {
        $content = json_encode($data);
        return file_put_contents($path, $content);
    }

}
